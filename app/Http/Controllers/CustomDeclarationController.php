<?php

namespace App\Http\Controllers;

use App\Models\CustomDeclaration;
use App\Models\DeclarationHistory;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CustomDeclarationController extends Controller
{
   public function index()
    {
        $declarations = CustomDeclaration::all(); 
           $declarations = CustomDeclaration::paginate(2);
        return view('dashboard', compact('declarations'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'declaration_number' => 'required|unique:custom_declarations',
            'status' => 'required',
        ]);

        CustomDeclaration::create([
            'declaration_number' => $request->declaration_number,
            'status' => $request->status,
        ]);

    return redirect()->back()->with('success', 'تم إضافة البيان الجمركي بنجاح!');
    }

 public function updateStatus(Request $request, $id) {
    $declaration = CustomDeclaration::findOrFail($id);
    
    if ($declaration->status !== $request->status) {
        $oldStatus = $declaration->status;
        
        $declaration->status = $request->status;
        $declaration->save();
        
        DeclarationHistory::create([
            'user_id' => auth()->id(),
            'declaration_id' => $declaration->id,
            'action' => "تم تغيير الحالة من '$oldStatus' إلى '{$request->status}'"
        ]);
        
        return redirect()->back()->with('success', 'تم تحديث الحالة بنجاح!');
    }
    
    return redirect()->back()->with('info', 'لم يتم تغيير الحالة');
}

   public function showHistory($id)
{
   $declaration = CustomDeclaration::findOrFail($id);
    $history = $declaration->histories()->orderBy('created_at', 'desc')->get(); 
        Carbon::setLocale('ar');
    return view('history', compact('history', 'declaration'));
}


}
