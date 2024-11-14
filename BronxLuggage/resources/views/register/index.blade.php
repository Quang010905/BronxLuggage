<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"
        integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href='{{asset('assets')}}/css/style.css' rel='stylesheet'>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>

<body>
    <div class="wrapper">
        <form action="{{url('add-customer')}}" method="post">
            @csrf
            <h1>Register</h1>
            @if ($errors->any())
            <div class="alert alert-danger" style="color:red">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
            <div class="input-box">
                <input type="text" placeholder="Username" name="customer_name" required>
                <i class='bx bxs-user'></i>
            </div>
            <div class="input-box">
                <input type="text" placeholder="Email" name="customer_email" required>
                <i class='fa fa-envelope'></i>
            </div>
            <div class="input-box">
                <input type="password" placeholder="Password" name="customer_password" required>
                <i class='bx bxs-lock-alt'></i>
            </div>
            <div class="input-box">
                <input type="text" placeholder="Phone" name="customer_phone" required>
                <i class='fa fa-phone'></i>
            </div>
            <div class="input-box">
                <input type="text" placeholder="Birthday" name="customer_birthday" id="birthday" required>
                <i class='fa fa-birthday-cake'></i>
            </div>
            <div class="input-box">
                <select name="customer_gender">
                    <option value="Man">Man</option>
                    <option value="Woman">Woman</option>
                </select>
                <i class='fa fa-genderless'></i>
            </div>

            <button type="submit" class="btn">Register</button>
        </form>
    </div>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.3/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://code.jquery.com/ui/1.13.3/jquery-ui.js"></script>
    <script>
        $(function() {
            $("#birthday").datepicker({
                dateFormat: 'dd/mm/yy'
            });
        });
    </script>
</body>


</html>