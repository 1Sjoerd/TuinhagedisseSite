<style> <?php include './assets/css/agenda.css'; ?> </style>

<div class="event-calendar">
  <div class="heading-title">
    <h2 class="title-calendar"> Ozze agenda </h2>
    <div class="icon-box">
       <i class="fas fa-calendar-alt"></i>
    </div>
  </div>
  <div class="events-body">
    <ul>
    <?php
      $sql = "SELECT * FROM `events` WHERE `date` >= CURDATE() ORDER BY `date` ASC LIMIT 3;";
      $result = $conn->query($sql);

      if ($result->num_rows > 0 ) {
        while ($row = $result->fetch_assoc()) {

          $origDate = $row["date"];
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
                    
          echo "<li>";
            echo "<a>";
              echo "<div class='event-left-content'>";
                echo "<div class='title-event'>";
                  echo "<h2> ".$row["title"]."</h2>";
                  echo "<div class='event-date'> ".$day." ".$month.", ".$year."</div>";
                  echo "<div class='event-location'> ".$row["location"]."</div>";
                echo "</div>";
              echo "</div>";
              echo "<div class='event-icon'>";
                echo "<div class='month'>".$month." </div>";
                echo "<div class='date'>".$day." </div> ";
              echo "</div>";
            echo "</a>";
          echo "</li>";
        }
      }
    ?>   
    </ul>
  </div>
  
</div>