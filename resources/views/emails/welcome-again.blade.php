@component('mail::message')
# Welcome

<h1>Hi, {{$user['name']}}</h1>
<p>You are wellcome in our team.We hope you are doing well. Wishing you an affluent journey with us.</p>
<p>Here is your Account Details</p>
<ul>
    <li>Email:- {{$user['email']}}</li>
    <li>Password:- {{$pass}}</li>
</ul>

@component('mail::button', ['url' => 'http://localhost:8000/login'])
  Login Here
@endcomponent
Thanks<br>
WeaverInnovation

@endcomponent
