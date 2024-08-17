<?php

namespace Yigitbayol\Nomuvel\Services;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class Individual
{
    private $nomuvel;
    private mixed $url;

    public function __construct(Nomuvel $nomuvel)
    {
        $this->nomuvel = $nomuvel;
        $this->url = config('nomuvel.env') === 'dev' ? config('nomuvel.test_url') : config('nomuvel.production_url');
    }

    /**
     * @param string $name "Ahmet"
     * @param string $surname "Soygazi"
     * @param string $tckn "11111111111"
     * @param string|null $phone "5555555555"
     * @param string|null $email "test@gmail.com
     * @param string $dob "1993-07-23"
     * @param string|null $pob "Kadıköy"
     * @param string|null $country "Türkiye"
     * @param string|null $city "İstanbul"
     * @param string|null $district "Sarıyer"
     * @param string|null $address "Maslak Mh.."
     * @param string|null $driverLicenceNo
     * @param string|null $vkn
     * @return array
     * @throws ConnectionException
     */
    function create(string $name, string $surname, string $tckn, string $dob): array
    {
        $baseUrl = $this->url . '/IndividualOnboarding/Individuals/Create';
        $postData = $data = [
            "Name" => "{$name}",
            "Surname" => "{$surname}",
            "TCKN" => "{$tckn}",
            "DateOfBirth" => "{$dob}",
            "Channel " => config('nomuvel.channel'),
            "RequestInfo" => [
                "ApiReferenceId" => Str::uuid()->toString(),
                "UserCode" => config('nomuvel.user_code'),
                "Pin" => config('nomuvel.pin'),
                "Channel" => config('nomuvel.sub_channel'),
            ]
        ];

        $response = Http::asJson()->post($baseUrl, $postData);

        if ($response->successful()) {
            return $response->json();
        } else {
            return [
                'error' => true,
                'message' =>  $response->body(),
                'request' => $postData
            ];
        }

    }

    /**
     * @param string $apiReferenceId "3e4cae28-622d-48b3-86b7-1a3cde436d31"
     * @param string $token "34a4cae28-622d-48b3-86b7-1a3cde436d31"
     * @param string $otpCode "123456"
     * @return array
     * @throws ConnectionException
     */
    function validateOtpToken(string $apiReferenceId, string $token, string $otpCode) : array
    {
        $baseUrl = $this->url . '/IndividualOnboarding/Individuals/OtpRequestValidation';

        $postData = [
            "Token" => $token,
            "OtpCode" => $otpCode,
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
                'message' =>  $response->body(),
                'request' => $postData
            ];
        }

    }

    /**
     * @param string $tckn "11111111111"
     * @return array
     * @throws ConnectionException
     */
    function getByTckn(string $tckn) : array
    {
        $baseUrl = $this->url . '/IndividualOnboarding/Individuals/GetByTckn';
        $postData = [
            "tckn" => $tckn,
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
                'message' =>  $response->body(),
                'request' => $postData
            ];
        }
    }

    /**
     * @param string $individualId "3e4cae28-622d-48b3-86b7-1a3cde436"
     * @return array
     * @throws ConnectionException
     */
    function getByIndividualId(string $individualId) : array
    {
        $baseUrl = $this->url . '/IndividualOnboarding/Individuals/GetByObjectId';

        $postData = [
            "individualObjectId" => $individualId,
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
                'message' =>  $response->body(),
                'request' => $postData
            ];
        }
    }

    /**
     * @param string $tckn "11111111111"
     * @return array
     * @throws ConnectionException
     */
    function queryByTckn(string $tckn) : array
    {
        $baseUrl = $this->url . '/IndividualOnboarding/Individuals/QueryByTckn';

        $postData = [
            "tckn" => $tckn,
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
                'message' =>  $response->body(),
                'request' => $postData
            ];
        }
    }
}
