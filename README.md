# Nomuvel - Laravel Nomupay Wrapper

Nomuvel, [Nomupay API](https://www.nomupay.com.tr) ile entegre olmanızı sağlayan bir Laravel wrapperıdır. Bu paket, Nomupay API'sindeki çeşitli işlemleri basit ve kolay kullanımlı bir Laravel arabirimi aracılığıyla gerçekleştirmenizi sağlar.

## Özellikler

- E-Money API ile entegrasyon
- Individual Onboarding API ile kullanıcı kaydı
- Otomatik endpoint oluşturma ve çağırma
- JSON formatında veri alışverişi
- Hata yönetimi ve durum kodu döndürme

## Kurulum

1. Projeye paketi ekleyin:

    ```bash
    composer require yigitbayol/nomuvel
    ```

2. Konfigürasyon dosyasını yayınlayın:

    ```bash
    php artisan vendor:publish --tag=nomuvel-config
    ```

3. `.env` dosyanıza gerekli API bilgilerini ekleyin:

    ```env
    NOMUVEL_ENV=dev
    NOMUVEL_TEST_URL=https://api-dev.nomupay.com.tr
    NOMUVEL_PRODUCTION_URL=https://api.nomuvel.com.tr
    NOMUVEL_USER_CODE=123456
    NOMUVEL_PIN=6A262E9E910364A9D7D0
    NOMUVEL_CHANNEL=MYAPP
    ```

## Kullanım

### E-Money API Örnekleri

#### E-Money Hesap Oluşturma

```php
use YourNamespace\Nomuvel\Facades\Nomuvel;

/**
 * Yeni bir E-Money hesabı oluşturun
 *
 * @param string $tckn "11111111111"
 * @param string $iban "TR1312312321312312"
 * @param string $successUrl "https://nomupay.com.tr/success"
 * @param string $errorUrl "https://nomupay.com.tr/fail"
 * @return array
 * @throws ConnectionException
 */
$response = Nomuvel::createAccount("11111111111", "TR1312312321312312", "https://nomupay.com.tr/success", "https://nomupay.com.tr/fail");

if ($response['error']) {
    // Hata yönetimi
    echo $response['message'];
} else {
    // Başarılı yanıt yönetimi
    print_r($response);
}
