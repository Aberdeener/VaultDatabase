<div class="container-fluid">
  <?php if (isset($_SESSION["timezone"])) {
    $timezone = $_SESSION["timezone"];
  } else {
    $timezone = "null";
  } ?>
  <br>
  <div class="row">
    <div class="col-md-12">
      <h1 class="text-center">Statistics</h1>
    </div>
  </div>
  <br>
  <div class="row" align="center">
    <div class="col-md-3">
    </div>
    <div class="col-md-6">
      <div class="row" style="background-color:#303030; border-radius:10px; padding:10px;">
        <div class="col-md-12">
          <h3>Check out some cool statistics!</h3>
          <p>Find some neat statistics generated from the player data we collect.</p>
        </div>
      </div>
    </div>
    <div class="col-md-3">
    </div>
  </div>
  <br>
  <div class="container">
    <br>
    <div class="row" align="center">
      <div class="col-md-3">
        <h4>New Players this Week</h4>
        <table class="stats">
          <thead>
            <tr>
              <th>Username</th>
              <th>First Seen</th>
            </tr>
          </thead>
          <tbody>
            <?php
            if ($result = $mysqli_d->query("SELECT uuid, username, firstseen FROM players WHERE firstseen + 604800000 > ROUND(UNIX_TIMESTAMP(CURTIME(4)) * 1000) - 604800000 ORDER BY firstseen DESC LIMIT 3")) {
              if ($result->num_rows > 0) {
                while ($row = $result->fetch_object()) {
                  echo "<td><img src='https://crafatar.com/avatars/" . $row->uuid . "?size=24&overlay'> <a href='https://vaultmc.net/?view=user&user=" . $row->uuid . "'>$row->username</a></td>";
                  echo "<td>" . secondsToDate($row->firstseen / 1000, $timezone, true) . "</td>";
                  echo "</tr>";
                }
              }
            }
            ?>
          </tbody>
        </table>
      </div>
      <div class="col-md-3">
        <h4>Last seen Players</h4>
        <table class="stats">
          <thead>
            <tr>
              <th>Username</th>
              <th>Last Seen</th>
            </tr>
          </thead>
          <tbody>
            <?php
            if ($result = $mysqli_d->query("SELECT uuid, username, lastseen FROM players ORDER BY lastseen DESC LIMIT 3")) {
              if ($result->num_rows > 0) {
                while ($row = $result->fetch_object()) {
                  echo "<tr>";
                  echo "<td><img src='https://crafatar.com/avatars/" . $row->uuid . "?size=24&overlay'> <a href='https://vaultmc.net/?view=user&user=" . $row->uuid . "'>$row->username</a></td>";
                  echo "<td>" . secondsToDate($row->lastseen / 1000, $timezone, true) . "</td>";
                  echo "</tr>";
                }
              }
            }
            ?>
          </tbody>
        </table>
      </div>
      <div class="col-md-3">
        <h4>Sessions</h4>
        <?php
        if ($result = $mysqli_d->query("SELECT COUNT(session_id) AS total_sessions, COUNT(DISTINCT uuid) AS players FROM sessions")) {
          if ($result->num_rows > 0) {
            while ($row = $result->fetch_object()) {
              echo "<br>";
              echo "There have been " . $row->total_sessions . " logins over all time from " . $row->players . " players.";
            }
          }
        }
        ?>
        <?php
        if ($result = $mysqli_d->query("SELECT COUNT(session_id) AS total_sessions, COUNT(DISTINCT username) AS players FROM sessions WHERE start_time + 604800000 > ROUND(UNIX_TIMESTAMP(CURTIME(4)) * 1000) - 604800000")) {
          if ($result->num_rows > 0) {
            while ($row = $result->fetch_object()) {
              echo "<br>";
              echo "There have been " . $row->total_sessions . " logins this week from " . $row->players . " players.";
            }
          }
        }
        ?>
      </div>
      <div class="col-md-3">
        <h4>Average Session Length</h4>
        <?php
        if ($result = $mysqli_d->query("SELECT AVG(duration) AS duration_avg FROM sessions")) {
          if ($result->num_rows > 0) {
            while ($row = $result->fetch_object()) {
              echo "<br>";
              echo secondsToTime($row->duration_avg / 1000);
            }
          }
        }
        ?>
      </div>
    </div>
    <br>
    <br>
    <div class="row" align="center">
      <div class="col-md-3">
        <h4>Players with most Playtime</h4>
        <table class="stats">
          <thead>
            <tr>
              <th>Username</th>
              <th>Playtime</th>
            </tr>
          </thead>
          <tbody>
            <?php
            if ($result = $mysqli_d->query("SELECT uuid, username, playtime FROM players ORDER BY playtime DESC LIMIT 3")) {
              if ($result->num_rows > 0) {
                while ($row = $result->fetch_object()) {
                  echo "<tr>";
                  echo "<td><img src='https://crafatar.com/avatars/" . $row->uuid . "?size=24&overlay'> <a href='https://vaultmc.net/?view=user&user=" . $row->uuid . "'>$row->username</a></td>";
                  echo "<td>" . secondsToTime($row->playtime / 20) . "</td>";
                  echo "</tr>";
                }
              }
            }
            ?>
          </tbody>
        </table>
      </div>
      <div class="col-md-3">
        <h4>Server total Playtime</h4>
        <?php
        if ($result = $mysqli_d->query("SELECT SUM(playtime) AS playtime_sum FROM players")) {
          if ($result->num_rows > 0) {
            while ($row = $result->fetch_object()) {
              echo "<br>";
              echo secondsToTime($row->playtime_sum / 20);
            }
          }
        }
        ?>
        <br>
        </br>
        <h4>Player average Playtime</h4>
        <?php
        if ($result = $mysqli_d->query("SELECT AVG(playtime) AS playtime_avg FROM players")) {
          if ($result->num_rows > 0) {
            while ($row = $result->fetch_object()) {
              echo "<br>";
              echo secondsToTime($row->playtime_avg / 20);
            }
          }
        }
        ?>
      </div>

      <div class="col-md-3">
        <h4>Total Players</h4>
        <?php
        if ($result = $mysqli_d->query("SELECT COUNT(uuid) AS total_players FROM players")) {
          if ($result->num_rows > 0) {
            while ($row = $result->fetch_object()) {
              echo "<br>";
              echo "A total of " . $row->total_players . " players have joined VaultMC.";
            }
          }
        }
        ?>
        <br>
        </br>
        <h4>Active / Inactive</h4>
        <i>Active meaning being online in the last 2 weeks.</i>
        <?php
        if ($result = $mysqli_d->query("SELECT COUNT(uuid) AS active_players FROM players WHERE lastseen + 1209600000 > ROUND(UNIX_TIMESTAMP(CURTIME(4)) * 1000) - 1209600000")) {
          if ($result->num_rows > 0) {
            while ($row = $result->fetch_object()) {
              echo "<br>";
              echo "<br>";
              echo "There are currently " . $row->active_players . " active players.";
            }
          }
        }
        ?>
        <?php
        if ($result = $mysqli_d->query("SELECT COUNT(uuid) AS inactive_players FROM players WHERE lastseen + 1209600000 < ROUND(UNIX_TIMESTAMP(CURTIME(4)) * 1000) - 1209600000")) {
          if ($result->num_rows > 0) {
            while ($row = $result->fetch_object()) {
              echo "<br>";
              echo "There are currently " . $row->inactive_players . " inactive players.";
            }
          }
        }
        ?>
      </div>

      <div class="col-md-3">
        <h4>Average TPS & Ping</h4>
        <?php
        if ($result = $mysqli_d->query("SELECT AVG(tps) AS tps_avg, AVG(CASE WHEN average_ping <> 0 THEN average_ping ELSE NULL END) AS ping_avg FROM statistics")) {
          if ($result->num_rows > 0) {
            while ($row = $result->fetch_object()) {
              echo "<br>";
              echo "VaultMC has averaged at " . substr_replace($row->tps_avg, "", -5) . " TPS with an average ping of " . substr_replace($row->ping_avg, "", -2) . "ms.";
            }
          }
        }
        ?>
      </div>
    </div>
    <br>
    <br>
    <div class="row" align="center">
      <div class="col-md-3">
      </div>
      <div class="col-md-3">
        <h4>Clanss most Members</h4>
        <table class="stats">
          <thead>
            <tr>
              <th>Name</th>
              <th># of Members</th>
            </tr>
          </thead>
          <tbody>
            <?php
            if ($result = $mysqli_c->query("SELECT COUNT(clan) AS members, clan FROM playerClans WHERE clan IS NOT NULL GROUP BY clan ORDER BY COUNT(clan) DESC LIMIT 5")) {
              if ($result->num_rows > 0) {
                while ($row = $result->fetch_object()) {
                  echo "<tr>";
                  echo "<td><a href='https://vaultmc.net/?view=clan&clan=" . $row->clan . "'>$row->clan</a></td>";
                  echo "<td>" . $row->members . " member" . (($row->members == 1) ? "." : "s.") . "</td>";
                  echo "</tr>";
                }
              }
            }
            ?>
          </tbody>
        </table>
      </div>
      <div class="col-md-3">
        <h4>Clans with highest Level</h4>
        <table class="stats">
          <thead>
            <tr>
              <th>Name</th>
              <th>Level, Experience</th>
            </tr>
          </thead>
          <tbody>
            <?php
            if ($result = $mysqli_c->query("SELECT name, level, experience FROM clans WHERE system_clan <> 1 ORDER BY experience DESC LIMIT 5")) {
              if ($result->num_rows > 0) {
                while ($row = $result->fetch_object()) {
                  echo "<tr>";
                  echo "<td><a href='https://vaultmc.net/?view=clan&clan=" . $row->name . "'>$row->name</a></td>";
                  echo "<td>Level " . $row->level . ", " . $row->experience . " xp</td>";
                  echo "</tr>";
                }
              }
            }
            ?>
          </tbody>
        </table>
        <br>
      </div>
    </div>
    <div class="col-md-3">
    </div>
  </div>
</div>