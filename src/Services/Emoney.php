<?php

namespace Yigitbayol\Nomuvel\Services;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class Emoney
{
    private $nomuvel;
    private $url;

    public function __construct(Nomuvel $nomuvel)
    {
        $this->nomuvel = $nomuvel;
        $this->url = config('nomuvel.env') === 'dev' ? config('nomuvel.test_url') : config('nomuvel.production_url');
    }

    /**
     * @param string $tckn "11111111111"
     * @param string $iban "TR1312312321312312"
     * @param string $successUrl "https://nomupay.com.tr/success"
     * @param string $errorUrl "https://nomupay.com.tr/fail"
     * @return array
     * @throws ConnectionException
     */
    public function createAccount(string $tckn, string $iban, string $successUrl, string $errorUrl) :array
    {

        $baseUrl = $this->url . '/EMoneyApi/CreateAccountWithTckn';
        $postData = [
            "TCKN" => "{$tckn}",
            "iban" => "{$iban}",
            "Channel" => config('nomuvel.channel'),
            "SuccessUrl" => "{$successUrl}",
            "FailUrl" => "{$errorUrl}",
            "RequestInfo" => [
                "ApiReferenceId" => Str::uuid()->toString(),
                "UserCode" => config('nomuvel.user_code'),
                "Pin" => config('nomuvel.pin'),
                "Channel" => config('nomuvel.channel'),
            ]
        ];

        $response = Http::asJson()->post($baseUrl, $postData);

        if ($response->successful()) {
            return $response->json();
        } else {
            return [
                'error' => true,
                'message' => $response->body(),
                'request' => json_encode($postData,JSON_PRETTY_PRINT)
            ];
        }

    }

    /**
     * @param string $senderClientId "34a4cae28-622d-48b3-86b7-1a3cde436d31"
     * @param string $senderAccountId "85a4cde28-622d-48b3-1a3cde436d31"
     * @param string $receiverIBAN "TR1111111111111111"
     * @param string $receiverTcknVkn "12345678910"
     * @param int $amount "1 TL için 100"
     * @param string $partnerReference "3e4cae28-622d-48b3-86b7-1a3cde436d31"
     * @param string|null $description "Test"
     * @return array
     * @throws ConnectionException
     */
    public function SendToExternalIBAN(string $senderClientId, string $senderAccountId, string $receiverIBAN, string $receiverTcknVkn, int $amount, string $partnerReference, string $description=null): array
    {
        $baseUrl = $this->url  . '/EMoneyApi/SendToExternalIBAN';
        $postData = $data = [
            "RequestInfo" => [
                "ApiReferenceId" => Str::uuid()->toString(),
                "UserCode" => config('nomuvel.user_code'),
                "Pin" => config('nomuvel.pin'),
                "Channel" => config('nomuvel.channel'),
            ],
            "senderClientId" => "{$senderClientId}",
            "senderAccountId" => "{$senderAccountId}",
            "receiverIBAN" => "{$receiverIBAN}",
            "receiverTcknVkn" => "{$receiverTcknVkn}",
            "amount" => $amount,
            "description" => "{$description}",
            "partnerReference" => "{$partnerReference}",
            "channel" => config('nomuvel.channel'),
        ];

        $response = Http::asJson()->post($baseUrl, $postData);

        if ($response->successful()) {
            return $response->json();
        } else {
            return [
                'error' => true,
                'message' => 'Bir hata oluştu: ' . $response->body()
            ];
        }
    }

    /**
     * @param string $senderAccountId "85a4cde28-622d-48b3-1a3cde436d31"
     * @param string $receiverAccountId "3e4cae28-622d-48b3-86b7-1a3cde436d31"
     * @param int $amount "1 TL için 100 girilmelidir"
     * @param string $referenceId "3e4cae28-622d-48b3-86b7-1a3cde436d31"
     * @param int $partnerId 0
     * @param string|null $description "Test"
     * @return array
     * @throws ConnectionException
     */
    function P2PSend(string $senderAccountId, string $receiverAccountId, int $amount, string $referenceId, int $partnerId, string $description=null): array
    {
        $baseUrl = $this->url  . '/EMoneyApi/P2PSend';

        $postData = [
            "RequestInfo" => [
                "ApiReferenceId" => Str::uuid()->toString(),
                "UserCode" => config('nomuvel.user_code'),
                "Pin" => config('nomuvel.pin'),
                "Channel" => config('nomuvel.channel'),
            ],
            "senderAccountId" => "{$senderAccountId}",
            "receiverAccountId" => "{$receiverAccountId}",
            "amount" => $amount,
            "description" => "{$description}",
            "referenceId" => "{$referenceId}",
            "PartnerId" => $partnerId
        ];

        $response = Http::asJson()->post($baseUrl, $postData);

        if ($response->successful()) {
            return $response->json();
        } else {
            return [
                'error' => true,
                'message' => $response->body(),
                'request' => json_encode($postData,JSON_PRETTY_PRINT)
            ];
        }
    }

    /**
     * @param string $accountId "85a4cde28-622d-48b3-1a3cde436d31"
     * @param int $amount "1 TL için 100 değeri girilmeli"
     * @param string $transferChannel "Ozan,Papara vb.."
     * @param string $referenceId "3e4cae28-622d-48b3-86b7-1a3cde436d31"
     * @param string $transferType "INSTANT veya GROUP"
     * @param string|null $transferDate "Sadece INSTANT için zorunludur. 2024-08-14T09:45:02.289Z"
     * @param string|null $description "Test"
     * @return array
     * @throws ConnectionException
     */
    function withdrawal(string $accountId, int $amount, string $transferChannel, string $referenceId, string $transferType, string $transferDate=null, string $description=null) : array
    {
        $baseUrl = $this->url  . '/EMoneyApi/Withdrawal';
        $postData = $data = [
            "RequestInfo" => [
                "ApiReferenceId" => Str::uuid()->toString(),
                "UserCode" => config('nomuvel.user_code'),
                "Pin" => config('nomuvel.pin'),
                "Channel" => config('nomuvel.channel'),
            ],
            "accountId" => "{$accountId}",
            "amount" => $amount,
            "description" => "{$description}",
            "transferChannel" => "{$transferChannel}",
            "referenceId" => "{$referenceId}",
            "transferType" => "{$transferType}",
            "transferDate" => "{$transferDate}",
        ];

        $response = Http::asJson()->post($baseUrl, $postData);

        if ($response->successful()) {
            return $response->json();
        } else {
            return [
                'error' => true,
                'message' => $response->body(),
                'request' => json_encode($postData,JSON_PRETTY_PRINT)
            ];
        }
    }

}
