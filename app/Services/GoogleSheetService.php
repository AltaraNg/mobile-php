<?php

namespace App\Services;

use Exception;
use Google\Client;
use Google\Service\Sheets;
use Google\Service\Sheets\ValueRange;


class GoogleSheetService
{
    public $client;
    public $service;
    public $range;

    /**
     * @throws \Google\Exception
     */
    public function __construct()
    {
        $this->client = $this->getClient();
        $this->service = new Sheets($this->client);
        $this->range = 'A2:D';
    }

    public function getConfigs()
    {
        return [
            "type" => "service_account",
            "project_id" => env('GOOGLE_SHEET_PROJECT_ID'),
            "private_key_id" => env('GOOGLE_SHEET_PRIVATE_KEY_ID'),
            "private_key" => env('GOOGLE_SHEET_PRIVATE_KEY'),
            "client_email" => env('GOOGLE_SHEET_CLIENT_EMAIL'),
            "client_id" => env('GOOGLE_SHEET_CLIENT_ID'),
            "auth_uri" => "https://accounts.google.com/o/oauth2/auth",
            "token_uri" => "https://oauth2.googleapis.com/token",
            "auth_provider_x509_cert_url" => "https://www.googleapis.com/oauth2/v1/certs",
            "client_x509_cert_url" => env('GOOGLE_SHEET_X509_CERT_URL')
        ];
    }

    /**
     * @throws \Google\Exception
     */
    public function getClient(): Client
    {

        $client = new Client();
        $client->setApplicationName('Google Sheets API PHP Quickstart');
        $client->setRedirectUri('http://127.0.0.1:8000/sheets');
        $client->setScopes(Sheets::SPREADSHEETS);
        $client->setAuthConfig($this->getConfigs());
        $client->setAccessType('offline');
        return $client;
    }

    public function createSheet(string $title): object
    {
        $service = new Sheets($this->client);
        $spreadsheet = new Sheets\Spreadsheet(
            [
                'properties' => [
                    'title' => $title
                ]
            ]
        );
        $response = $service->spreadsheets->create($spreadsheet);
        return (object)[
            'spreadsheetId' => $response->spreadsheetId,
            'spreadsheetUrl' => $response->spreadsheetUrl,
            'title' => $response->properties->title
        ];
    }

    public function readSheet(string $documentId): ValueRange
    {
        return $this->service->spreadsheets_values->get($documentId, $this->range);
    }

    public function writeSheet(array $values, string $documentId): int
    {
        $body = new ValueRange([
            'values' => $values
        ]);
        $params = [
            'valueInputOption' => 'RAW'
        ];
        $result = $this->service->spreadsheets_values->update(
            $documentId,
            $this->range,
            $body,
            $params
        );
        return $result->getUpdatedCells();
    }

    public function appendSheet(array $values, string $documentId): Sheets\AppendValuesResponse
    {
        $body = new ValueRange([
            'values' => $values
        ]);
        $params = [
            'valueInputOption' => 'RAW'
        ];
        return $this->service->spreadsheets_values->append(
            $documentId,
            $this->range,
            $body,
            $params
        );
    }

    public function clearSheet(string $documentId): Sheets\ClearValuesResponse
    {
        $body = new Sheets\ClearValuesRequest();
        return $this->service->spreadsheets_values->clear(
            $documentId,
            $this->range,
            $body
        );
    }

    public function getHeaders($doc)
    {
        return $doc->values[0];
    }
}
