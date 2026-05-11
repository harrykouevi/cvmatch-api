<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Resume</title>
</head>
<body>

<h1>{{ $resume['full_name'] }}</h1>
<h3>{{ $resume['headline'] }}</h3>

<p>{{ $resume['professional_summary'] }}</p>

<h3>Skills</h3>
<ul>
@foreach($resume['skills'] as $skill)
    <li>{{ $skill }}</li>
@endforeach
</ul>

<h3>Experience</h3>
@foreach($resume['professional_experience'] as $exp)
    <p><strong>{{ $exp['title'] }}</strong></p>
    <ul>
    @foreach($exp['bullets'] as $b)
        <li>{{ $b }}</li>
    @endforeach
    </ul>
@endforeach

</body>
</html>
