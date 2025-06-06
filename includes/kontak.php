<style> <?php include './assets/css/standardblock.css'; ?> </style>
<style> <?php include './assets/css/kontak.css'; ?> </style>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<div class="block-overview">
    <div class="heading-title">
        <h2 class="block-title"> Kóntak </h2>
    </div>
    <div class="block-text">
        <b>VV de Tuinhagedisse</b></br>
        Rick van Havere</br>
        <a href="mailto:sikkertaris@vvdetuinhagedisse.nl" target="_blank" rel="noopener">sikkertaris@vvdetuinhagedisse.nl</a></br>
        Op het Schoor 23</br>
        6041 AV Roermond<br>
        <div class="row">
            <a><button id="memberenrolbutton" class="enrollment-button">Lid waere?!</button></a>
            <a href="https://www.facebook.com/vvdetuinhagedisse" target="_blank"><i class="fa fa-facebook"></i></a>
            <a href="https://www.instagram.com/vvdetuinhagedisse/" target="_blank"><i class="fa fa-instagram"></i></a>
        </div>
        <div id="enrollmentForm" class="glassform" style="display: none;">
            <div class="form-grid">
                <form id="enrollmentFormElement" method="post" action="process_enrollment.php" enctype="multipart/form-data" class="glass-form">
                    Insjriefformulier</br>
                    <div class="form-row">
                        <div class="form-group">
                            <span class="icon-label"><i class="fa fa-user"></i></span>
                            <input type="text" id="firstname" name="firstname" placeholder="Veurnaam" autocomplete="given-name" required>
                        </div>
                        <div class="form-group">
                            <span class="icon-label"><i class="fa fa-font"></i></span>
                            <input type="text" id="initials" name="initials" placeholder="Veurletters" required>
                        </div>
                        <div class="form-group">
                            <span class="icon-label"><i class="fa fa-user"></i></span>
                            <input type="text" id="lastname" name="lastname" placeholder="Achternaam" autocomplete="family-name" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <span class="icon-label"><i class="fa fa-calendar"></i></span>
                            <input type="date" id="dob" name="dob" autocomplete="bday" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <span class="icon-label"><i class="fa fa-map-marker-alt"></i></span>
                            <input type="text" id="postalcode" name="postalcode" placeholder="Postcode (1234AB)" autocomplete="postal-code" required pattern="[1-9][0-9]{3}[A-Z]{2}">
                        </div>
                        <div class="form-group">
                            <span class="icon-label"><i class="fa fa-home"></i></span>
                            <input type="number" id="housenumber" name="housenumber" placeholder="Hoesnómmer" required>
                        </div>
                        <div class="form-group">
                            <span class="icon-label"><i class="fa fa-plus"></i></span>
                            <input type="text" id="addition" name="addition" placeholder="Toevoeging (optioneel)">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <span class="icon-label"><i class="fa fa-road"></i></span>
                            <input type="text" id="street" name="street" placeholder="Sjtraotnaam" autocomplete="off" required>
                        </div>
                        <div class="form-group">
                            <span class="icon-label"><i class="fa fa-city"></i></span>
                            <input type="text" id="city" name="city" placeholder="Woonplaats" autocomplete="off" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <span class="icon-label"><i class="fa fa-envelope"></i></span>
                            <input type="email" id="email" name="email" placeholder="E-mail" autocomplete="email" required>
                        </div>
                        <div class="form-group">
                            <span class="icon-label"><i class="fa fa-phone"></i></span>
                            <input type="tel" id="phone" name="phone" placeholder="Tillefoonnómmer" autocomplete="tel" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group" style="display:none;">
                            <span class="icon-label"><i class="fa fa-envelope"></i></span>
                            <input type="email" id="emailparent" name="emailparent" placeholder="E-mail aojers" autocomplete="email" required>
                        </div>
                        <div class="form-group" style="display:none;">
                            <span class="icon-label"><i class="fa fa-phone"></i></span>
                            <input type="tel" id="phoneparent" name="phoneparent" placeholder="Tillefoonnómmer aojers" autocomplete="tel" required>
                        </div>
                    </div>
                    
                    <div class="form-row">
                      <div class="form-group">
                        Jeug
                        <label class="glass-checkbox"><input type="checkbox" name="groep_jeug[]" value="Jeugraod"> Jeugraod</label>
                        <label class="glass-checkbox"><input type="checkbox" name="groep_jeug[]" value="Jeuggarde"> Jeuggarde</label>
                        <label class="glass-checkbox"><input type="checkbox" name="groep_jeug[]" value="Crew"> Crew</label>
                      </div>
                      <div class="form-group">
                        Groot</strong>
                        <label class="glass-checkbox"><input type="checkbox" name="groep_groot[]" value="Begl. jeug"> Begl. jeug</label>
                        <label class="glass-checkbox"><input type="checkbox" name="groep_groot[]" value="Raodslid"> Raodslid</label>
                        <label class="glass-checkbox"><input type="checkbox" name="groep_groot[]" value="Dansgarde"> Dansgarde</label>
                        <label class="glass-checkbox"><input type="checkbox" name="groep_groot[]" value="Aektesse"> Aektesse</label>
                        <label class="glass-checkbox"><input type="checkbox" name="groep_groot[]" value="Createam"> Createam</label>
                        <label class="glass-checkbox"><input type="checkbox" name="groep_groot[]" value="Overig"> Overig</label>
                      </div>
                    </div>
                    <p>Aub juuste aafdeiling aanvinke. Indeen lid van meerdere aafdeilinge, gaer allemaol aanvinke.</p>
                    <p>Contribusie seizoen 2022/2023*:</br>
                    Jeugd: €….., inclusief circa 8 consumpties</br>
                    Volwassenen: €….., geen consumpties</br>
                    <i style="font-size: 0.8rem;">*Indeen lid van de jeuggarde én de grote garde, wurd de contribusie voor de jeug aangehaaje.</i></p>

                    <p>De statuten en huishoudelijk regelement zeen van toepassing op alle leeje.</p>

                    <p><strong>Betaling contribusie:</strong></br>
                    Betaling van de jaorlijkse contribusie zól in eine keer plaatsvinje middels ein betaalverzeuk.
                    Dit wurd gestuurd nao 't op dit formulier ingevuld mobiel tillefoonnómmer (veur minderjeurige nao 't ingevulde tillefoonnómmer van de aojer).</br>
                    Indeen dit neet meugelijk is wurd ein passende oplossing gezoch in euverlegk mit de centefoekser.</p>

                    <div class="form-row">
                      <div class="form-group" style="flex: 1 1 100%;">
                        <label for="signature">Handtekening:</label>
                        <canvas id="signature" width="300" height="100" style="border: 1px solid #ccc; border-radius: 6px; background: #fff;"></canvas>
                        <button type="button" id="clearSignature" style="margin-top: 0.5rem;">Wis handtekening</button>
                      </div>
                    </div>
                    <input type="hidden" name="signatureData" id="signatureData">
                    <input type="submit" value="Insjrieve" class="glassform-submit-button">
                </form>
            </div>
        </div>    

        <script>
            document.getElementById('memberenrolbutton').addEventListener('click', function() {
                var form = document.getElementById('enrollmentForm');
                document.getElementById('enrollmentFormElement').reset();
                form.style.display = form.style.display === 'none' ? 'block' : 'none';
            });

            document.getElementById('postalcode').addEventListener('blur', function() {
                const postalcodeInput = document.getElementById('postalcode');
                // Verwijder spaties en zet om naar hoofdletters
                postalcodeInput.value = postalcodeInput.value.replace(/\s+/g, '').toUpperCase();
                fetchStreetNameIfValid(); // Roep de API-aanroep functie aan
            });
            
            document.getElementById('housenumber').addEventListener('blur', fetchStreetNameIfValid);
            
            function fetchStreetNameIfValid() {
                const postalcodeInput = document.getElementById('postalcode');
                const housenumberInput = document.getElementById('housenumber');
                const streetInput = document.getElementById('street');
                const cityInput = document.getElementById('city');
            
                const postalcode = postalcodeInput.value.trim();
                const housenumber = housenumberInput.value.trim();
            
                // Controleer of beide velden volledig en geldig zijn
                const postalcodeRegex = /^[1-9][0-9]{3}[A-Z]{2}$/;
                if (postalcodeRegex.test(postalcode) && housenumber !== '') {
                    // API-aanroep
                    fetch(`includes/dashboardIncludes/get_street.php?postalcode=${encodeURIComponent(postalcode)}&housenumber=${encodeURIComponent(housenumber)}`)
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                streetInput.value = data.street;
                                cityInput.value = data.city || ''; // Voeg stad toe als beschikbaar
                            } else {
                                alert(data.message || 'Straatnaam niet gevonden. Controleer de invoer.');
                                streetInput.value = '';
                            }
                        })
                }
            }


            function toggleParentFields() {
                const dobInput = document.getElementById('dob');
                const phoneParentInput = document.getElementById('phoneparent');
                const emailParentInput = document.getElementById('emailparent');

                const phoneParentGroup = phoneParentInput.closest('.form-group');
                const emailParentGroup = emailParentInput.closest('.form-group');

                const dob = new Date(dobInput.value);
                const today = new Date();
                let age = today.getFullYear() - dob.getFullYear();
                const m = today.getMonth() - dob.getMonth();
                if (m < 0 || (m === 0 && today.getDate() < dob.getDate())) {
                    age--;
                }

                const showParentFields = age < 18;

                phoneParentInput.required = showParentFields;
                emailParentInput.required = showParentFields;

                phoneParentGroup.style.display = showParentFields ? 'flex' : 'none';
                emailParentGroup.style.display = showParentFields ? 'flex' : 'none';
            }

            document.getElementById('dob').addEventListener('change', toggleParentFields);

            // Handtekening canvas functionaliteit
            const canvas = document.getElementById('signature');
            if (canvas) {
                const ctx = canvas.getContext('2d');
                let drawing = false;

                // Mouse events
                canvas.addEventListener('mousedown', e => {
                    drawing = true;
                    ctx.beginPath();
                    canvas.classList.remove('error');
                    ctx.moveTo(e.offsetX, e.offsetY);
                });
                canvas.addEventListener('mousemove', e => {
                    if (drawing) {
                        ctx.lineTo(e.offsetX, e.offsetY);
                        ctx.stroke();
                    }
                });
                canvas.addEventListener('mouseup', () => drawing = false);
                canvas.addEventListener('mouseout', () => drawing = false);

                // Touch events
                canvas.addEventListener('touchstart', e => {
                    e.preventDefault();
                    const touch = e.touches[0];
                    const rect = canvas.getBoundingClientRect();
                    ctx.beginPath();
                    canvas.classList.remove('error');
                    ctx.moveTo(touch.clientX - rect.left, touch.clientY - rect.top);
                    drawing = true;
                });
                canvas.addEventListener('touchmove', e => {
                    e.preventDefault();
                    if (drawing) {
                        const touch = e.touches[0];
                        const rect = canvas.getBoundingClientRect();
                        ctx.lineTo(touch.clientX - rect.left, touch.clientY - rect.top);
                        ctx.stroke();
                    }
                });
                canvas.addEventListener('touchend', () => drawing = false);

                document.getElementById('clearSignature').addEventListener('click', () => {
                    ctx.clearRect(0, 0, canvas.width, canvas.height);
                });
            }
            // Voeg handtekening-data toe aan hidden input bij submit, met validatie of het canvas leeg is
            document.getElementById('enrollmentFormElement').addEventListener('submit', function (event) {
                const signatureInput = document.getElementById('signatureData');
                // Controleer of het canvas leeg is
                const blank = document.createElement('canvas');
                blank.width = canvas.width;
                blank.height = canvas.height;

                if (canvas.toDataURL() === blank.toDataURL()) {
                    canvas.classList.add('error');
                    canvas.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    alert('Gelieve uw handtekening te plaatsen voordat u het formulier verzendt.');
                    event.preventDefault();
                    return;
                } else {
                    canvas.classList.remove('error');
                }

                signatureInput.value = canvas.toDataURL();
            });
        </script>
    </div>
</div>