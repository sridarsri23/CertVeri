<?php

namespace App\Exports;

use App\Models\Certificate;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class CertExport implements FromCollection, WithHeadings, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Certificate::all();
    }

    public function headings(): array
    {
        // Specify the column titles here
        return [
            'Certificate Number',
            'Student Name',
            'Issue Date',
            'Expire Date',
            'Qualification',
            'Accredited By',
            'Created At',
            'Updated At',
            // Add more column titles as needed
        ];
    }

    public function map($certificate): array
    {
        // Map the fields to be exported
        return [
            $certificate->certificate_no,
            $certificate-> student_name,
            $certificate->issue_date,
            $certificate->expire_date,
            $certificate->qualification,
            $certificate->accredited_by,
            $certificate->created_at,
            $certificate->updated_at,
            // Map more fields as needed
        ];
    }
}
