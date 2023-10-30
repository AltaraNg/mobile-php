<?php

namespace App\Http\Controllers;

use App\Http\Resources\CustomerResource;
use App\Models\Customer;
use App\Models\Document;
use App\Models\Verification;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use InvalidArgumentException;

/**
 * @group Document
 *
 * @authenticated
 *
 * Api Endpoints for Customer document upload
 *
 */
class DocumentController extends Controller
{
    /**
     *
     * Upload
     *
     * This endpoint is used for document upload, available types are passport,id_card,guarantor_id,proof_of_income
     *
     * @bodyParam document file required The id of the user. No-example
     * @bodyParam type string required The type of document been uploaded. Example: passport
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'document' => ['required', 'file', 'max:512'],
            'type' => ['in:passport,id_card,guarantor_id,proof_of_income', 'string']
        ]);
        $document_column = $this->generateColumn($request->type);
        $customer = auth()->user();
        if ($request->hasFile('document') && $request->file('document')->isValid()) {
            $image = $request->file('document');
            $filePath = $request->type . '/' . $this->getFileName($image);
            if ($this->uploadToS3($filePath, $image)) {
                Document::updateOrCreate(
                    ['customer_id' => $customer->id],
                    [
                        $document_column => $filePath,
                        'user_id' => 1,
                        'staff_name' => 'mobile',
                    ]
                );
                Verification::updateOrCreate(
                    ['customer_id' => $customer->id],
                    [
                        $request->type => true,
                    ]
                );
            }
        }
        return $this->sendSuccess(['user' => new CustomerResource(auth()->user()->fresh())], str_replace("_", ' ', ucfirst($request->type)) . ' uploaded successfully');
    }

    public function uploadDocument(Request $request)
    {
        $this->validate($request, [
            'document' => ['required', 'file', 'max:512'],
            'type' => ["required", 'in:passport,id_card,guarantor_id,proof_of_income,bank_statement', 'string']
        ]);
        if (!$request->hasFile('document') || !$request->file('document')->isValid()) {
            throw new InvalidArgumentException("please provide valid document");
        }
        $document = $request->file('document');
        $filePath = $request->type . '/' . $this->getFileName($document);
        $this->uploadToS3($filePath, $document);
        return $this->sendSuccess(['document' => $filePath], 'uploaded successfully');
    }


    public function  uploadToS3($filePath, string $image)
    {
        $s3 = Storage::disk('s3');
        return  $s3->put($filePath, file_get_contents($image), 'public');
    }

    protected function getFileName($file)
    {
        /** generate a random string and append the file extension to the random string */
        return Str::random(32) . '.' . $file->extension();
    }

    public function generateColumn(string $type)
    {
        if ($type == 'passport') {
            $document_url = 'passport_url';
        }
        if ($type == 'id_card') {
            $document_url = 'id_card_url';
        }
        if ($type == 'guarantor_id') {
            $document_url = 'guarantor_id_url';
        }
        if ($type == 'proof_of_income') {
            $document_url = 'proof_of_income_url';
        }
        return $document_url;
    }
}
