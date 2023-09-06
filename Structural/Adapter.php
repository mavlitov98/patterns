<?php

declare(strict_types=1);

namespace Structural\Adapter;

/**
 * Паттерн Adapter.
 *
 * В данном примере мы имеем интерфейс PaymentProcessorInterface, который представляет собой систему для выполнения платежей.
 * У нас есть реализация этого интерфейса в классе PaymentProcessor, который осуществляет платежи.
 *
 * Далее у нас есть сторонний класс ThirdPartyPayment, предоставляющий свою систему для платежей,
 * которую мы хотим адаптировать к нашему интерфейсу PaymentProcessorInterface.
 *
 * Мы создаем адаптер ThirdPartyPaymentAdapter, который принимает объект ThirdPartyPayment в конструкторе
 * и адаптирует его вызовы метода makePayment() к методу pay() интерфейса PaymentProcessorInterface.
 * Адаптер также преобразует ответ ThirdPartyPaymentResponse в ожидаемый формат результата.
 *
 * После этого мы можем использовать как оригинальную реализацию PaymentProcessor,
 * так и адаптированный ThirdPartyPaymentAdapter для осуществления платежей.
 */
// Имеющийся интерфейс, который нужно адаптировать
interface PaymentProcessorInterface
{
    public function pay(int $amount): string;
}

// Реализация имеющегося интерфейса
class PaymentProcessor implements PaymentProcessorInterface
{
    public function pay(int $amount): string
    {
        // Логика для осуществления платежа
        return "Payment of {$amount} accepted.";
    }
}

// Адаптер для сторонней платежной системы
class ThirdPartyPaymentAdapter implements PaymentProcessorInterface
{
    public function __construct(
        private readonly ThirdPartyPayment $thirdPartyPayment,
    ) {
    }

    public function pay(int $amount): string
    {
        // Адаптация вызова сторонней платежной системы
        $response = $this->thirdPartyPayment->makePayment($amount);

        // Предоставление результата в формате, ожидаемом клиентом
        return $response->isSuccess
            ? "Payment of {$response->amount} accepted."
            : 'Payment error.';
    }
}

// Сторонняя платежная система, которую нужно адаптировать
class ThirdPartyPayment
{
    public function makePayment(int $amount): ThirdPartyPaymentResponse
    {
        // Логика для осуществления платежа в сторонней системе
        // ...

        // Возвращаем результат платежа
        return new ThirdPartyPaymentResponse(true, $amount);
    }
}

// Результат платежа сторонней платежной системы
class ThirdPartyPaymentResponse
{
    public function __construct(
        public readonly bool $isSuccess,
        public readonly int $amount,
    ) {
    }
}

// Использование адаптера
$paymentProcessor = new PaymentProcessor();
$adapter = new ThirdPartyPaymentAdapter(new ThirdPartyPayment());

var_dump($paymentProcessor->pay(100)); // Ожидаемый результат: "Payment of 100 accepted."
var_dump($adapter->pay(200)); // Ожидаемый результат: "Payment of 200 accepted."