<!doctype html>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>华丽的宿舍导入界面</title>
</head>
<body>
<h1>华丽的宿舍导入界面</h1>
<?php
if(!$errors->isEmpty()){
    echo '<pre>';
    var_dump($errors->toArray());
    echo '</pre>';
}
?>
@if(Session::has('status'))
    <h2 style="color: #d43f3a">{!! Session::get('status') !!}</h2>
@endif
<form action="{!! route('import_dormitory') !!}" method="POST">
    {!! csrf_field() !!}
    班级：
    <select name="department_class_id">
        @foreach($classes as $class)
            <option value ="{!! $class->id !!}">{!! $class->__toString() !!}</option>
        @endforeach
    </select><br/><br/>
    性别：<label><input name="gender" type="radio" value="0" />男</label>
        <label><input name="gender" type="radio" value="1" />女</label>
    <br/><br/>
    宿舍号：<input type="text" name="dorm_num" value="{!! old('dorm_num') !!}" /><br/><br/>
    <label><input name="type" type="radio" value="normal" />普通宿舍</label>
    <br/><br/>
    <label><input name="type" type="radio" value="hesu" />合宿舍</label>
    ，合宿人数<input type="number" name="hesu_people_num">
    <br/><br/>
    <label><input name="type" type="radio" value="chasu" />插宿</label>
    ，插宿人数<input type="number" name="chasu_people_num"><br/><br/>
    <input type="submit">
</form>
</body>
</html>