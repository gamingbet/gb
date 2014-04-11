<?php
if( !defined("__LOAD__") )
{
    exit();
    return false;
}
?>        
<div class="historia_p">
            <h2>Kontakt</h2>
            <p class="info">Poniższy formularz umożliwi Ci kontakt z nami. Odpowiemy najszybciej jak to możliwe.</p>
            <form action="form/send.php" method="post" id="contactform">
                <fieldset>
                    <input type="text" name="contact_name" class="empty1" placeholder="Imię i nazwisko" required="required" tabindex="1" /><br>
                    <input type="email" name="contact_email" placeholder="Adres e-mail" required="required" tabindex="2" class="empty1" /><br>
                    <textarea name="contact_body" placeholder="Treść wiadomości" required="required" tabindex="3" class="empty1"></textarea><br>
                    <br><br><input type="submit" value="Wyślij" tabindex="5" class="empty1"/>
                    <input type="hidden" name="contact_check_data" value="" />
                </fieldset>
            </form>
        </div>
        
        <script src="main.js"></script>

</div>