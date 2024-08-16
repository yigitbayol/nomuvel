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
    function create(string $name, string $surname, string $tckn,string $dob, string $phone=null, string $email=null, string $pob=null, string $country=null, string $city=null, string $district=null, string $address=null, string $driverLicenceNo=null, string $vkn=null) : array
    {
        $baseUrl = $this->url . '/IndividualOnboarding/Individuals/Create';
        dd($this->env);
        $postData = $data = [
            "Name" => "{$name}",
            "Surname" => "{$surname}",
            "TCKN" => "{$tckn}",
            "VKN" => $vkn,
            "Phone" => "{$phone}",
            "Email" => "{$email}",
            "DateOfBirth" => "{$dob}",
            "PlaceOfBirth" => "{$pob}",
            "Country" => "{$country}",
            "City" => "{$city}",
            "District" => "{$district}",
            "Address" => "{$address}",
            "DriverLicenceNumber" => "{$driverLicenceNo}",
            "Channel " => config('nomuvel.channel'),
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
                'message' => 'Bir hata oluştu: ' . $response->body()
            ];
        }

    }
}
