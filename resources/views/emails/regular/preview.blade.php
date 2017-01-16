{!!  ( $body ) !!}
<form action = "{{ url('email/regular/send') }}">
<input type="hidden" name="to" value="{{ $to }}" />
<input type="hidden" name="subject" value="{{ $subject }}" />
<input type="hidden" name="subject" value="{{ $subject }}" />
<input type="hidden" name="send" value="send" />
<button type="submit" name="send">Send</button>
</form>
</body>
</div>
</html>
