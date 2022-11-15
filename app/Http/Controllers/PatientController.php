<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;

class PatientController extends Controller
{

    // Menampilkan seluruh data pasien covid
    # Membuat method index
    public function index()
    {
        
        $patient = Patient::all();
        if($patient){

            $data = [
                'message' => 'Get all resource',
                'data' => $patient,
                'status code' => 200
            ];
        } else {
            $data = [
                'message' => 'Data is empty',
                'status code' => 200
            ];
        }

        # Mengembalikan data (json) dan status kode 200
        return response()->json($data,$data['status code']);
    }

    # Menambahkan Resource
    # Membuat method store
    public function store(Request $request)
    {
        # Membuat validasi dan menangkap data resource
        $validation = $request->validate([
            # Kolom => rules
            'name' => 'required',
            'phone' => 'numeric|required',
            'address' => 'required',
            'status' => 'required',
            'in_date_at' => 'date|required',
            'out_date_at' => 'date|required'
        ]);

        # Menggunakan Eloquent create untuk store data
        $patient = Patient::create($validation);

        $data = [
            'message' => 'Resource is added successfully',
            'data' => $patient,
            'status code' => 201
        ];

        # Mengembalikan resource data (json) dan status kode
        return response()->json($data,$data['status code']);
    }

    # Mendapatkan single detail resource
    # Membuat method show
    public function show($id)
    {
        $patient = Patient::find($id);

        if($patient)
        {
            $data = [
                'message' => 'Get Detail Resource',
                'data' => $patient,
                'status code' => 200,
            ];
        } else {
            $data = [
                'message' => 'Resource not found',
                'status code' => 404,
            ];
        }

        # Mengembalikan data (json) dan status kode
        return response()->json($data,$data['status code']);
    }
    
    
    # Memperbarui single resource
    # Membuat method update
    public function update(Request $request, $id)
    {
        # Mencari id patient yang ingin didapatkan
        $patient = Patient::find($id);
        if ($patient) {
            # Membuat validasi dan menangkap data request
            $validation = $request->validate([
                # Kolom => rules
                'name' => 'required',
                'phone' => 'numeric|required',
                'address' => 'required',
                'status' => 'required',
                'in_date_at' => 'date|required',
                'out_date_at' => 'date|required'
            ]);
            
            # Melakukan update data
            $patient->update($validation);
            
            $data = [
                'message' => 'Resource is update successfully',
                'data' => $patient,
                'status code' => 200,
            ];      
        } else {
            $data = [
                'message' => 'Resource not found',
                'status code' => 404,
            ];
            
        }
        # Mengembalikan data (json) dan status kode
        return response()->json($data, $data['status code']);
    }
    
    # Menghapus single resource data
    # Membuat method destroy
    public function destroy($id){

        # Mencari id patient yang ingin didapatkan
        $patient = Patient::find($id);

        if($patient){
            # Melakukan delete data
            $patient->delete();

            $data = [
                'message' => 'Resource is deleted successfully',
                'status code' => 200,
            ];
        } else {
            $data = [
                'message' => 'Resource not found',
                'status code' => 404,
            ];
        }
        # Mengembalikan data (json) dan status kode
        return response()->json($data, $data['status code']);
    }

    # Membuat method search
    # Mencari resource by name
    function search($name)
    {
        # Mendapatkan data patient dengan parameter name
        $patient = Patient::where('name','LIKE','%'.$name.'%')->get();

        # Memeriksa 
        if($patient->count() !== 0){
            $data = [
                'message' => 'Get searched resource',
                'data' => $patient,
                'status code' => 200,
            ];
        } else {
            $data = [
                'message' => 'Resource not found',
                'status code' => 404,
            ];
        }

        # Mengembalikan data (json) dan status kode
        return response()->json($data,$data['status code']);
    }

    # Membuat method positve
    # Mendapatkan resource yang positive
    public function positive($positive)
    {
        # Menggunakan eloquent where dan get
        $patient  = Patient::where('status', $positive)->get();

        # Jika respon berhasil
        if ($patient->count() !== 0) {
            $data = [
                'message' => 'Get positive resource patient covid',
                'total' => $patient->count(),
                'data' => $patient,
                'status code' => 200,
            ];
        }

        # Mengembalikan data (json) dan status kode 200
        return response()->json($data, $data['status code']);
    }

    # Membuat method recovered
    # Mendapatkan resource yang sembuh 
    public function recovered($recovered)
    {
        # Menggunakan eloquent where dan get
        $patient = Patient::where('status', $recovered)->get();

        # Response jika resource berhasil
        if ($patient->count() !== 0){
            $data = [
                'message' => 'Get recovered resource patient covid',
                'total' => $patient->count(),
                'data' => $patient,
                'status code' => 200,
            ];
            # Mengembalikan data (json) dan status kode 200
            return response()->json($data,$data['status code']);
        }
    }

    # Membuat method dead
    # Mendapatkan resource yang meninggal
    public function dead($dead)
    {
        # Menggunakan eloquent where dan get
        $patient = Patient::where('status', $dead)->get();

        # Resource jika berhasil
        if ($patient->count() !== 0){
            $data = [
                'message' => 'Get dead resource patient covid',
                'total' => $patient->count(),
                'data' => $patient,
                'status code' => 200,
            ];
            # Mengembalikan data json dan status kode
            return response()->json($data,$data['status code']);
        }
    }

}
