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
<form action="{!! route('import_dormitories') !!}" method="POST">
    {!! csrf_field() !!}
    班级：
    <select name="department_class_id">

        @foreach($classes as $class)
            <option value ="{!! $class->id !!}">{!! $class->__toString() !!}</option>
        @endforeach
    </select><br/><br/>
    性别：<label><input name="gender" type="radio" value="0" />男</label>
        <label><input name="gender" type="radio" value="1" />女</label>
    宿舍号：<input type="text" name="dormitory" />
    <label><input name="gender" type="radio" value="0" />插宿</label>
    <label><input name="gender" type="radio" value="1" />女</label>
</form>
</body>
</html>