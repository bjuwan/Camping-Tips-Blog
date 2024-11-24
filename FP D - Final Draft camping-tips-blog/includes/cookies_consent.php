<?php



function hasUserGivenConsent() {
    return isset($_COOKIE['cookie_consent']);
}


function setConsentCookie($consent) {
    setcookie('cookie_consent', $consent, time() + (365 * 24 * 60 * 60), "/"); 
}


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cookie_consent'])) {
    setConsentCookie($_POST['cookie_consent']);
    exit(header("Location: " . $_SERVER['PHP_SELF']));
}


if (!hasUserGivenConsent()):
?>

<div id="cookie-consent-banner" style="display: none;">
    <p>We use cookies to enhance your experience on our website. By continuing to use this site, you agree to our use of cookies.</p>
    <form method="post" action="">
        <button type="submit" name="cookie_consent" value="accept" id="accept-cookies">Accept</button>
        <button type="submit" name="cookie_consent" value="decline" id="decline-cookies">Decline</button>
    </form>
    <a href="privacy-policy.php" target="_blank">Learn More</a>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var cookieBanner = document.getElementById('cookie-consent-banner');
    cookieBanner.style.display = 'block';


    function hideBanner() {
        cookieBanner.style.display = 'none';
    }


    document.getElementById('accept-cookies').addEventListener('click', function() {

        hideBanner();
    });

    document.getElementById('decline-cookies').addEventListener('click', function() {

        hideBanner();
    });
});
</script>

<style>
#cookie-consent-banner {
    position: fixed;
    bottom: 0;
    left: 0;
    right: 0;
    background-color: #f1f1f1;
    padding: 20px;
    text-align: center;
    box-shadow: 0 -2px 10px rgba(0,0,0,0.1);
    z-index: 1000;
}

#cookie-consent-banner p {
    margin-bottom: 10px;
}

#cookie-consent-banner button {
    margin: 0 10px;
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

#accept-cookies {
    background-color: #4CAF50;
    color: white;
}

#decline-cookies {
    background-color: #f44336;
    color: white;
}

#cookie-consent-banner a {
    display: block;
    margin-top: 10px;
    color: #2C5530;
    text-decoration: none;
}

#cookie-consent-banner a:hover {
    text-decoration: underline;
}
</style>

<?php
endif;
?>

