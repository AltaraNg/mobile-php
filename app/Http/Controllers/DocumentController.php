<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Document;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

/**
 * @group Document upload
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
     * This endpoint is used for document upload
     * 
     * @bodyParam document file required The id of the user. No-example
     * @bodyParam type string The type of document been uploaded. Example: passport
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'document' => ['required', 'max:512', 'dimensions:max_width=1200,max_height=1200', 'mimes:jpeg,jpg,png,svg'],
            'type' => ['required', 'string', 'in:passport,id_card,guarantor_id,proof_of_income']
        
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
            }
        }
        return $this->sendSuccess([], str_replace("_", ' ', ucfirst($request->type)) . ' uploaded successfully');
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
