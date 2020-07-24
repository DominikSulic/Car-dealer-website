<?php
if(!isset($_COOKIE["prihvaceno"])){
    echo "<div id='overlay'>
                <div style='padding:20px'>
                    <h2 >Za nastavak korištenja ove stranice morate prihvatiti uvjete korištenja</h2>
                </div>
                <button onclick='off()'>Prihvacam</button>
            </div>";
            setcookie("prihvaceno", "da", time() + (86400 * 2), "/"); // 86400 = 1 day
}
?>