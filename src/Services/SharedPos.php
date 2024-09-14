<?php

namespace Yigitbayol\Nomuvel\Services;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class SharedPos
{
    protected $nomuvel;

    protected $url;

    public function __construct($nomuvel)
    {
        $this->nomuvel = $nomuvel;
        $this->url = config('nomuvel.env') === 'dev' ? config('nomuvel.pos_test_url') : config('nomuvel.pos_production_url');
    }

    /**
     * @param array $tokenInfo Token bilgileri
     * @param array $customerInfo Müşteri bilgileri (isteğe bağlı)
     * @param string $language Dil seçeneği (isteğe bağlı)
     * @param int $price Ödeme tutarı (100 ile çarpılmış hali)
     * @param string $mpay Benzersiz sipariş kimliği (isteğe bağlı)
     * @param string $currencyCode Para birimi kodu
     * @param string $description İşlem açıklaması
     * @param string $errorUrl Hata durumunda yönlendirilecek URL
     * @param string $successUrl Başarılı işlem sonrası yönlendirilecek URL
     * @param string $extraParam Ek parametreler (isteğe bağlı)
     * @param string $paymentContent Ödeme içeriği
     * @param int $paymentTypeId Ödeme tipi (isteğe bağlı)
     * @param int $installmentOptions Taksit seçenekleri (isteğe bağlı)
     * @param array $cardTokenization Kart tokenizasyon bilgileri (isteğe bağlı)
     * @return array
     * @throws ConnectionException
     */
    public function createPayment(
        array $tokenInfo,
        array $customerInfo = null,
        string $language = null,
        int $price,
        string $mpay = null,
        string $currencyCode,
        string $description,
        string $errorUrl,
        string $successUrl,
        string $extraParam = null,
        string $paymentContent,
        int $paymentTypeId = null,
        int $installmentOptions = null,
        array $cardTokenization = null
    ): array {
        $baseUrl = $this->url;
        $postData = [
            "ServiceType" => "WDTicket",
            "OperationType" => "Sale3DSURLProxy",
            "Token" => $tokenInfo,
            "Price" => $price,
            "CurrencyCode" => $currencyCode,
            "Description" => $description,
            "ErrorURL" => $errorUrl,
            "SuccessURL" => $successUrl,
            "PaymentContent" => $paymentContent,
        ];

        if ($customerInfo) $postData["CustomerInfo"] = $customerInfo;
        if ($language) $postData["Language"] = $language;
        if ($mpay) $postData["MPAY"] = $mpay;
        if ($extraParam) $postData["ExtraParam"] = $extraParam;
        if ($paymentTypeId) $postData["PaymentTypeId"] = $paymentTypeId;
        if ($installmentOptions) $postData["InstallmentOptions"] = $installmentOptions;
        if ($cardTokenization) $postData["CardTokenization"] = $cardTokenization;

        
        $response = Http::asJson()->post($baseUrl, $postData);

        dd($response->json());

        if ($response->successful()) {
            return $response->json();
        } else {
            return [
                'error' => true,
                'message' => $response->body(),
                'request' => json_encode($postData, JSON_PRETTY_PRINT)
            ];
        }
    }


    // Diğer ortak POS işlemleri burada olabilir (örneğin ödeme durumu sorgulama, iptal işlemi, vb.)
}