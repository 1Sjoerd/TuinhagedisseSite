<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Herschildering & Controle Tool</title>
    <link rel="stylesheet" href="style.css">
    <script>
        let paintOptions = [
            "Sikkens Rubbol XD High Gloss",
            "Sigma S2U Allure Gloss",
            "Sikkens Alphaloxan Flex",
            "Sikkens REDOX PUR FINISH HIGH GLOSS",
            "Sigma Sigma Pearl Clean Semi-Matt"
        ];

        function addPaintSection() {
            var container = document.getElementById("paints_container");
            var paintSection = document.createElement("div");
            paintSection.className = "paint-section";
            paintSection.innerHTML = `
                <h3>Geverfd onderdeel</h3>
                <label for="surface[]">Naam:</label>
                <input type="text" name="surface[]" required>
                <br>
                <label for="paint[]">Verfsoort:</label>
                <select name="paint[]" required></select>
                <br>
                <label for="location[]">Locatie:</label>
                <select name="location[]" required>
                    <option value="Woning">Woning</option>
                    <option value="Horeca">Horeca</option>
                    <option value="Openbare ruimtes">Openbare ruimtes</option>
                    <option value="Industrie">Industrie</option>
                </select>
                <br>
                <label for="direction[]">Richting (indien buiten):</label>
                <select name="direction[]">
                    <option value="">Niet van toepassing</option>
                    <option value="noord-oost">Noord-Oost</option>
                    <option value="zuid-west">Zuid-West</option>
                </select>
                <br>
                <label for="last_maintenance[]">Laatste onderhoudsdatum:</label>
                <input type="date" name="last_maintenance[]" required>
                <br><br>
            `;
            container.appendChild(paintSection);
            updatePaintOptions();
        }

        function addNewPaintField() {
            var container = document.getElementById("new_paint_container");
            var paintField = document.createElement("div");
            paintField.id = "new_paint_field";
            paintField.className = "new-paint-field";
            paintField.innerHTML = `
                <h3>Nieuwe Verfsoort</h3>
                <label for="new_paint_name">Naam:</label>
                <input type="text" id="new_paint_name" required>
                <br>
                <label for="new_paint_durability">Duurzaamheid (jaren):</label>
                <input type="number" id="new_paint_durability" required>
                <br>
                <label for="new_paint_material">Materiaal:</label>
                <select id="new_paint_material" required>
                    <option value="Hout">Hout</option>
                    <option value="Beton/Muren">Beton/Muren</option>
                    <option value="Muren">Muren</option>
                    <option value="Staal">Staal</option>
                </select>
                <br>
                <label for="new_paint_location">Plek (Binnen/Buiten):</label>
                <select id="new_paint_location" required>
                    <option value="Binnen">Binnen</option>
                    <option value="Buiten">Buiten</option>
                </select>
                <br>
                <label for="new_paint_aftrek_no">Aftrek noord-oost (jaren):</label>
                <input type="number" id="new_paint_aftrek_no">
                <br>
                <label for="new_paint_aftrek_zw">Aftrek zuid-west (jaren):</label>
                <input type="number" id="new_paint_aftrek_zw">
                <br>
                <label for="new_paint_control">Controle (jaren):</label>
                <input type="number" id="new_paint_control" required>
                <br><br>
                <button style="background-color: #33b249;" type="button" onclick="saveNewPaint()">Voeg toe</button>
                <button style="background-color: #FF474C;" type="button" onclick="cancelNewPaint()">Annuleer</button>
                <br><br><br>
            `;
            container.appendChild(paintField);
        }

        function saveNewPaint() {
            var name = document.getElementById("new_paint_name").value;
            var durability = document.getElementById("new_paint_durability").value;
            var material = document.getElementById("new_paint_material").value;
            var location = document.getElementById("new_paint_location").value;
            var aftrek_no = document.getElementById("new_paint_aftrek_no").value || 0;
            var aftrek_zw = document.getElementById("new_paint_aftrek_zw").value || 0;
            var control = document.getElementById("new_paint_control").value;

            if (name && durability && material && location && control) {
                paintOptions.push(name);
                updatePaintOptions();

                var hiddenFieldsContainer = document.getElementById("hidden_fields");
                var hiddenFields = `
                    <input type="hidden" name="new_paint_name[]" value="${name}">
                    <input type="hidden" name="new_paint_durability[]" value="${durability}">
                    <input type="hidden" name="new_paint_material[]" value="${material}">
                    <input type="hidden" name="new_paint_location[]" value="${location}">
                    <input type="hidden" name="new_paint_aftrek_no[]" value="${aftrek_no}">
                    <input type="hidden" name="new_paint_aftrek_zw[]" value="${aftrek_zw}">
                    <input type="hidden" name="new_paint_control[]" value="${control}">
                `;
                hiddenFieldsContainer.innerHTML += hiddenFields;

                var container = document.getElementById("new_paint_container");
                var paintField = document.getElementById("new_paint_field");
                container.removeChild(paintField);
            } else {
                alert("Vul alle velden in.");
            }
        }

        function cancelNewPaint() {
            var container = document.getElementById("new_paint_container");
            var paintField = document.getElementById("new_paint_field");
            container.removeChild(paintField);
        }

        function updatePaintOptions() {
            var selects = document.querySelectorAll('select[name="paint[]"]');
            var options = paintOptions.map(function(paint) {
                return `<option value="${paint}">${paint}</option>`;
            }).join('');

            selects.forEach(function(select) {
                var selectedValue = select.value;
                select.innerHTML = options;
                if (selectedValue) {
                    select.value = selectedValue;
                }
            });
        }

        document.addEventListener('DOMContentLoaded', updatePaintOptions);
    </script>
</head>
<body>
    <div class="container">
        <h1>Herschildering & Controle Tool</h1>
        <form action="result.php" method="post">
            <div id="paints_container">
                <h3>Geverfd onderdeel</h3>
                <label for="surface[]">Naam:</label>
                <input type="text" name="surface[]" required>
                <br>
                <label for="paint[]">Verfsoort:</label>
                <select name="paint[]" required>
                </select>
                <br>
                <label for="location[]">Locatie:</label>
                <select name="location[]" required>
                    <option value="Woning">Woning</option>
                    <option value="Horeca">Horeca</option>
                    <option value="Openbare ruimtes">Openbare ruimtes</option>
                    <option value="Industrie">Industrie</option>
                </select>
                <br>
                <label for="direction[]">Richting (indien buiten):</label>
                <select name="direction[]">
                    <option value="">Niet van toepassing</option>
                    <option value="noord-oost">Noord-Oost</option>
                    <option value="zuid-west">Zuid-West</option>
                </select>
                <br>
                <label for="last_maintenance[]">Laatste onderhoudsdatum:</label>
                <input type="date" name="last_maintenance[]" required>
                <br><br>
            </div>
            <button style="background-color: #33b249;" type="button" onclick="addPaintSection()">+ Voeg geverfd onderdeel toe</button>
            <input type="submit" value="Bereken">
            <br><br>
            <h2>Nieuwe verfsoorten toevoegen</h2>
            <div id="new_paint_container"></div>
            <button style="background-color: #33b249;" type="button" onclick="addNewPaintField()">+ Voeg nieuwe verfsoort toe</button>
            <br><br>
            <div id="hidden_fields"></div>
        </form>
    </div>
</body>
</html>
