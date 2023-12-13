<form method="post" name="redirect" action="https://secure.ccavenue.com/transaction/transaction.do?command=initiateTransaction"> 
	<?php
	echo "<input type=text name=encRequest value=$encrypted_data>";
	echo "<input type=text name=access_code value=$access_code>";
	?>
</form>

<script language='javascript'>document.redirect.submit();</script>

