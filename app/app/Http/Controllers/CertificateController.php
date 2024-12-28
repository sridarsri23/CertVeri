<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use App\Policies\CertificatePolicy;
use Illuminate\Support\Facades\Gate;
use App\Models\User;
use App\Rules\UniqueFirstFourDigits;

class CertificateController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:create,App\Models\Certificate')->only(['create', 'store']);
    }
    

    public function index()
    {
        $certificates = Certificate::latest()->take(50)->orderBy('created_at', 'desc')->get();   
             return view('certificates.index', compact('certificates'));
    }

    public function create()
    {
      // dd(Auth::user()->isEditor());
    //  $this->authorize('create', Certificate::class);
        return view('certificates.create');

    }

    public function store(Request $request)
    {
        //$this->authorize('create', Certificate::class);
        // Validation rules for the form fields
        $rules = [
            'certificate_no' => ['required', 'regex:/^\d{4}\/\d{8}$/', Rule::unique('certificates', 'certificate_no'),new UniqueFirstFourDigits],
            'student_name' => 'required',
            'issue_date' => 'required|date',
            'expire_date' => 'required|date|after_or_equal:issue_date',
            'qualification' => 'required',
            'accredited_by' => 'required',
        ];

        // Validate the request data based on the defined rules
        $validatedData = $request->validate($rules);

        // Create a new certificate record using the validated data
        Certificate::create($validatedData);

        //log
        $user = Auth::user();
        $this->logUserActivity($user->name." created certificate : " . $validatedData['certificate_no']);
        
        
        // Redirect the user to the index page with a success message
        return redirect()->route('certificates-index')->with('success', 'Certificate created successfully.');
    }

    public function show($id)
    {
        $certificate = Certificate::findOrFail($id);
              //log
              $user = Auth::user();
              $this->logUserActivity($user->name." viewed certificate : " . $certificate['certificate_no']);
   
// Generate the QR code
$appUrl = url('/');
$certificateNo = $certificate->certificate_no;
$certificateNo = str_replace('/', 'T', $certificateNo);
$url = 'https://bstgt.com/cert-veri' . '/?cn=' . $certificateNo;
$qrCodeData = $certificateNo . '|' . $url;

// Encode the QR code data
$encodedData = urlencode($qrCodeData); 

// Generate the QR code URL
$qrCodeUrl = 'https://chart.googleapis.com/chart?chs=500x500&cht=qr&chl=' . $encodedData;

// Get the image data
$imageData = file_get_contents($qrCodeUrl);

// Save the image to the subdomain's public/qr_codes folder
$tempcertificateNo = str_replace('T', '-', $certificateNo);
$qrCodeImageName = $certificate->student_name . '_' . $tempcertificateNo . '.png';
$qrCodeImagePath = '/home/bstgtcom/certv.bstgt.com/qr_codes/' . $qrCodeImageName;
file_put_contents($qrCodeImagePath, $imageData);

// Get the full URL to the stored image
$qrCodeImageUrl = 'https://certv.bstgt.com/qr_codes/' . $qrCodeImageName;

return view('certificates.show', [
    'certificate' => $certificate,
    'qrCodeUrl' => $qrCodeImageUrl,
]);

           // dd($certificate);
        //$qrCodeUrl = route('certificates-qrcode', ['certificate' => $certificate]);

       // return view('certificates.show', ['certificate' => $certificate, 'qrCodeUrl' => $qrCodeUrl]);
    }

    public function edit($id)
    {
        // Check if the user is an editor
        if (Auth::user()->isEditor()) {
            // Redirect to the index page with an error message
            return redirect()->route('certificates.index')->with('error', 'Editors are not allowed to edit certificates.');
        }
        $certificate = Certificate::findOrFail($id);
        return view('certificates.edit', compact('certificate'));
    }

    public function update(Request $request, $id)
    {
        // Validation rules for the form fields
        $rules = [
            'certificate_no' => ['required', 'regex:/^\d{4}\/\d{8}$/', Rule::unique('certificates', 'certificate_no')->ignore($id),new UniqueFirstFourDigits],
            'student_name' => 'required',
            'issue_date' => 'required|date',
            'expire_date' => 'required|date|after_or_equal:issue_date',
            'qualification' => 'required',
            'accredited_by' => 'required',
        ];

        // Validate the request data based on the defined rules
        $validatedData = $request->validate($rules);

        // Find the certificate by ID and update its details with the validated data
        $certificate = Certificate::findOrFail($id);
        $certificate->update($validatedData);


        //log
        $user = Auth::user();
        $this->logUserActivity($user->name." updated certificate : " . $validatedData['certificate_no']);
        

        // Redirect the user to the show page with a success message
        return redirect()->route('certificates.show', $certificate->id)->with('success', 'Certificate updated successfully.');
    }

    public function destroy($id)
    {
        // Check if the user is an editor
        if (Auth::user()->isEditor()) {
            // Redirect to the index page with an error message
            return redirect()->route('certificates-index')->with('error', 'Editors are not allowed to delete certificates.');
        }
        // Find the certificate by ID and delete it
        $certificate = Certificate::findOrFail($id);
        $certificate->delete();

     //log
     $user = Auth::user();
     $this->logUserActivity($user->name." deleted certificate : " . $certificate['certificate_no']);
     

        // Redirect the user to the index page with a success message
        return redirect()->route('certificates-index')->with('success', 'Certificate deleted successfully.');
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        $certificates = Certificate::where('certificate_no', 'LIKE', "%{$query}%")->get();
        //$certificates = Certificate::where('certificate_no', 'LIKE', $query . '%')->get();
        return new JsonResponse($certificates);
    }
    
    public function searchb(Request $request)
{

   
    $query = $request->input('query');
   //  var_dump($query);
             $certificate = Certificate::where('certificate_no', 'LIKE', "%{$query}%")->first();

    
              //log
              $user = Auth::user();
              $this->logUserActivity($user->name." viewed certificate : " . $certificate['certificate_no']);
   
// Generate the QR code
$certificateNo = $certificate->certificate_no;
$certificateNo = str_replace('/', 'T', $certificateNo);
$url = 'https://bstgt.com/cert-veri' . '/?cn=' . $certificateNo;
$qrCodeData = $certificateNo . '|' . $url;

// Encode the QR code data
$encodedData = urlencode($qrCodeData);

// Generate the student name and certificate number part of the QR code image name
$studentName = strtolower(str_replace(' ', '_', $certificate->student_name));
$qrCodeImageName = $studentName . '_' . $certificate->certificate_no . '.png';

// Generate the QR code URL
$qrCodeUrl = 'https://chart.googleapis.com/chart?chs=500x500&cht=qr&chl=' . $encodedData;

// Save the QR code image with the custom name
file_put_contents($qrCodeImageName, file_get_contents($qrCodeUrl));

return view('certificates.show', [
    'certificate' => $certificate,
    'qrCodeUrl' => $qrCodeUrl,
    'qrCodeImageName' => $qrCodeImageName,
]);
}


    private function logUserActivity($message)
    {
        // Log user activity to Laravel log
        \Illuminate\Support\Facades\Log::info($message);
    }


public function verifyCertificate(Request $request, $certificateNo)
{
    // Get the API token from the request headers
    $apiToken = $request->header('Authorization');

    $apiToken = str_replace('Bearer ', '', $apiToken);
    // Query the user by the API token
    $user = User::where('api_token', $apiToken)->first();

    // Check if the user exists and the token is valid
    if ($user) {
        // Query the certificate by the provided certificate number
        $certificateNo = str_replace('T', '/', $certificateNo);
        $certificate = Certificate::where('certificate_no', $certificateNo)->first();
        $currentDate = now();
        // Check if the certificate exists and is valid
        if ($certificate && $certificate->issue_date <= $currentDate && $currentDate <= $certificate->expire_date) {
            // Return the verification result along with the certificate details
            $certificate->makeHidden(['id']);
            return response()->json([
                'valid' => true,
                'certificate' => $certificate,
            ]);
        } else {
            // Return the verification result as invalid
            return response()->json([
                'valid' => false,
            ]);
        }
    } else {
        // Return the verification result as unauthorized
        return response()->json([
            'valid' => false,
        ])->setStatusCode(401);
    }
}


}
