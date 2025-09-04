<style>
    /* Responsive Footer */
.footer {
    background-color: #C2CCEB;
    padding: 20px;
    height: auto;
    min-height: 200px;
    display: flex;
    flex-wrap: wrap;
    justify-content: space-around;
    align-items: flex-start;
    font-family: 'Roboto', sans-serif;
    margin-top: 50px;
    border-top: 5px solid #002597;
}

.footer-column {
    flex: 1 1 200px;
    display: flex;
    flex-direction: column;
    align-items: center;
    margin: 10px;
    text-align: center;
}

.footer-column img {
    width: 100px;
    height: auto;
}

.footer-column ul {
    list-style-type: none;
    padding: 0;
}

.footer-column ul li {
    margin-bottom: 10px;
}

.footer-column ul li a {
    text-decoration: none;
    color: black;
}

.footer-columnfooter-logo .logo {
    display: flex;
    flex-direction: column;
    align-items: center;

}
    </style>
<?php

?>
<footer class="footer">
    <div class="footer-column">
        <img src="../assest/213-2134506_social-media-icons-twitter-facebook-instagram-png-removebg-preview.png" alt="Social Media">
    </div>
    <div class="footer-column">
        <ul>
            <li><a href="#">Privacy Policy</a></li>
            <li><a href="#">FAQ</a></li>
            <li><a href="#">T&C</a></li>
            <li><a href="#">Contact Us</a></li>
        </ul>
    </div>
    <div class="footer-column footer-logo">
        <div class="logo">
            <img src="../assest/Bus-logo-temokate-on-transparent-background-PNG-removebg-preview.png" alt="Bus Logo">
            <div class="logo-text">SLTB-Transit<span>Ease</span></div>
        </div>
        <p>Team Apex<br>teamapex@gmail.com</p>
    </div>
    <div class="footer-column">
        <img src="../assest/nee.png" alt="SLTB Logo">
        <p><b>Sri Lanka Transport Board</b><br>No. 200, Kirula Road, Colombo 5<br>
        +94(0)11 7706000 | info@sltb.lk</p>
    </div>
</footer>
