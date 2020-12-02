<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Todo;
use Illuminate\Support\Facades\DB;

class TodosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
//        $todos = Todo::all();
        $todos = DB::table('todos')->where('completed','0')->paginate(5);//truyen vao so todo se hien thi tren 1 trang
        return view('todos.index')->with('todos',$todos);
    }
    public function completed()
    {
//        $todos = Todo::all();
        $todos = DB::table('todos')->where('completed','1')->paginate(5);//truyen vao so todo se hien thi tren 1 trang
        return view('todos.completed')->with('todos',$todos);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('todos.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate(request(), [//validate() có hai tham số +Tham số thứ nhất là đối tượng request chứa thông tin về dữ liệu được gửi lên từ người dùng.
                                    //                          +Tham số thứ hai là một mảng các quy tắc kiểm tra cho từng trường nhập liệu có trong request.
            'name' => 'required|min:3|max:30',//bắt buộc nhập, tối thiểu 6 ký tự, tối đa 12 ký tự.
            'description' => 'required' //bắt buộc nhập
        ]);
        $data = request()->all();//lấy tất cả dữ liệu được gửi đến từ form thông qua Laravel request với phương thức all()

        //Tạo một model Todo() và thiết lập dữ liệu có được từ form nhập
        $todo = new Todo();
        $todo->name = $data['name'];
        $todo->description = $data['description'];
        $todo->completed = false;

        $todo->save();

        session()->flash('success', 'Todo created successfully.');//lưu thông tin trạng thái vào Session và trong request tiếp theo sẽ hiển thị nó lên

        //chuyển hướng người dùng về trang danh sách todos
        return redirect('/todos');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Todo $todo)
    {
        return view('todos.show')->with('todo', $todo);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Todo $todo)
    {
        return view('todos.edit')->with('todo', $todo);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Todo $todo)
    {
        $this->validate(request(), [
            'name' => 'required|min:6|max:12',
            'description' => 'required'
        ]);

        $data = request()->all();

        $todo->name = $data['name'];
        $todo->description = $data['description'];

        $todo->save();

        session()->flash('success', 'Cập nhật thành công.');

        return redirect('/todos');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Todo $todo)
    {
        $todo->delete();

        session()->flash('success', 'Xoá việc thành công!.');

        return redirect('/todos');
    }

    public function complete(Todo $todo)
    {
        $todo->completed = true;
        $todo->save();

        session()->flash('success', 'Bạn đã hoàn thành công việc!.');

        return redirect('/todos');
    }
}
