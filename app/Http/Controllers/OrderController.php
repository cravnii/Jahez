<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        // يتم استدعاء هذه الدالة لعرض قائمة بجميع الطلبات.
    }

    public function store(Request $request)
    {
        // يتم استدعاء هذه الدالة لحفظ الطلب الجديد في قاعدة البيانات.
    }

    public function show($id)
    {
        // يتم استدعاء هذه الدالة لعرض تفاصيل طلب واحد معين بناءً على معرفه.
    }

    public function update(Request $request, $id)
    {
        // يتم استدعاء هذه الدالة لتحديث معلومات طلب معين بناءً على معرفه.
    }

    public function destroy($id)
    {
        // يتم استدعاء هذه الدالة لحذف طلب معين بناءً على معرفه.
    }

}
