<html>
<head>
<title>Email Message</title>
</head>
<body>
<div width="100%">
<form action = "{{ url('email/regular/preview') }}">
to:<br/>
<textarea name="to" style="width:100%;" rows="5">{{ $to }}</textarea>
subject:<br/>
<textarea name="subj" style="width:100%;" rows="1"></textarea>
body:<br/>
<textarea name="body" style="width:100%;" rows="10"></textarea>
<button type="submit" name="preview">Preview</button>
</form>
</body>
</div>
</html>
