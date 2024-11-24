<footer>
    <div class="footer-content">
        <p>&copy; <?php echo date("Y"); ?> Wilderness Adventures. All rights reserved.</p>
        <nav class="footer-nav">
            <a href="privacy-policy.php">Privacy Policy</a>
            <a href="#" id="cookie-settings">Cookie Settings</a>
        </nav>
    </div>
</footer>

<div id="cookie-consent-mini" style="display: none;">
    <p>We use cookies to enhance your experience.</p>
    <div class="cookie-buttons">
        <button id="accept-cookies">Accept</button>
        <button id="decline-cookies">Decline</button>
    </div>
</div>

<div id="cookie-thank-you" style="display: none;">
    <p>Thank you for making your choice.</p>
    <button id="close-thank-you">Close</button>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    function showCookieConsent() {
        $('#cookie-consent-mini').show();
    }

    function hideCookieConsent() {
        $('#cookie-consent-mini').hide();
    }

    function showThankYou() {
        $('#cookie-thank-you').show();
        setTimeout(function() {
            $('#cookie-thank-you').hide();
        }, 3000); 
    }

    function setCookiePreference(preference) {
        localStorage.setItem('cookieConsent', preference);
        hideCookieConsent();
        showThankYou();
        applyCookiePreference(preference);
    }

    function applyCookiePreference(preference) {
        if (preference === 'accepted') {
            
            console.log('Cookies accepted');
        } else {
            
            console.log('Cookies declined');
        }
    }

    
    var cookieConsent = localStorage.getItem('cookieConsent');
    
    if (!cookieConsent) {
        showCookieConsent();
    } else {
        applyCookiePreference(cookieConsent);
    }

    $('#accept-cookies').click(function() {
        setCookiePreference('accepted');
    });

    $('#decline-cookies').click(function() {
        setCookiePreference('declined');
    });

    
    $('#cookie-settings').click(function(e) {
        e.preventDefault();
        showCookieConsent();
    });

    
    $('#close-thank-you').click(function() {
        $('#cookie-thank-you').hide();
    });
});
</script>

<style>
footer {
    background-color: var(--primary-color);
    color: white;
    padding: 20px 0;
    margin-top: auto;
}

.footer-content {
    display: flex;
    justify-content: space-between;
    align-items: center;
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
}

.footer-nav a {
    color: white;
    text-decoration: none;
    margin-left: 20px;
}

.footer-nav a:hover {
    text-decoration: underline;
}

#cookie-consent-mini, #cookie-thank-you {
    position: fixed;
    bottom: 20px;
    right: 20px;
    background-color: #f1f1f1;
    padding: 15px;
    border-radius: 5px;
    box-shadow: 0 0 10px rgba(0,0,0,0.1);
    z-index: 1000;
}

.cookie-buttons {
    margin-top: 10px;
}

.cookie-buttons button, #close-thank-you {
    margin-right: 10px;
    padding: 5px 10px;
    cursor: pointer;
    background-color: var(--primary-color);
    color: white;
    border: none;
    border-radius: 3px;
}

.cookie-buttons button:hover, #close-thank-you:hover {
    background-color: var(--secondary-color);
}
</style>
