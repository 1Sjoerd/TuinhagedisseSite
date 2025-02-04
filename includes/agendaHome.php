<style> <?php include './assets/css/agenda.css'; ?> </style>

<div class="event-calendar">
    <div class="heading-title">
        <h2 class="title-calendar"> Ozze agenda </h2>
        <div class="icon-box">
            <i style="color:white; text-shadow: 2px 2px rgb(16, 90, 24);" class="fas fa-calendar-alt"></i>
        </div>
    </div>
    <div class="events-body">
        <ul>
            <?php
                $eventItems = $conn->query("SELECT * FROM `events` WHERE `date` >= CURDATE() ORDER BY `date` ASC LIMIT 4;")->fetch_all(MYSQLI_ASSOC);
                if (empty($eventItems)) {
                    echo "<li><a><div class='event-left-content'><div class='title-event'><h2>  Gein evenemente gepland </h2><div class='event-location'> Nog aeve wachte </div></div></div></a></li>";
                } else {
                    foreach ($eventItems as $eventItem):
                        $eventId = $eventItem['id'];
                        $newsItem = $conn->query("SELECT * FROM `news` WHERE `eventid` = $eventId ORDER BY `date` DESC LIMIT 1;")->fetch_assoc();
                        $href = $newsItem ? "href='#' onclick='submitForm(".$newsItem['id'].")'" : "";
            ?>
            <li>
                <a <?php echo $href; ?>>
                    <div class='event-left-content'>
                        <div class='title-event'>
                            <h2> <?php echo htmlspecialchars($eventItem['title']); ?></h2>
                            <div class='event-location'> <?php echo htmlspecialchars($eventItem['location']); ?></div>
                        </div>
                    </div>
                    <div class='event-icon'>
                        <?php
                            $origDate = $eventItem['date'];
                            $newDate = date("d-M-Y", strtotime($origDate));
                            $newDate = explode('-', $newDate);
                  
                            $day  = $newDate[0];
                            $month   = $newDate[1];
                            if ($month == "Mar") {
                              $month = "Mrt";
                            } elseif ($month == "May") {
                              $month = "Mei";
                            } elseif ($month == "Oct") {
                              $month = "Okt";
                            }
                  
                            $year = $newDate[2];
                  
                            $time = date("H:i:s", strtotime($origDate));
                        ?>


                        <div class='month'><?php echo htmlspecialchars($month); ?></div>
                        <div class='date'><?php echo htmlspecialchars($day); ?></div>
                    </div>
                </a>
            </li>
            <?php endforeach; }?>
        </ul>
    </div>
</div>