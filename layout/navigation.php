<div class="navigation">
  <h2 class="h2-heading">
    <?php
    $sql = "select username from user where email = '" . $_SESSION['account'] . "'";
    $statement = $connect->prepare($sql);
    $statement->execute();
    $result = $statement->fetch();
    echo $result[0];
    ?>
  </h2>
  <div class="navigation-search">

    <?php
    preg_match('/index\.php/', $_SERVER['REQUEST_URI'], $match1);
    preg_match('/index\.php/', $_SERVER['PHP_SELF'], $match2);

    if ($match1 || $match2) {
    ?>
    <form action="<?php $_SERVER['PHP_SELF'] ?>" method='get' class="navigation-search-form">
      <input type="text" class="navigation-search-input" name="input-search" placeholder="Search"
        onkeyup="liveSearch(this.value)">
    </form>
    <?php
    }
    ?>
  </div>
  <ul class="navigation-list">
    <li class='navigation-list-item'>
      <a href='index.php' class='navigation-list-item-link'>Home</a>
    </li>
    <?php if ($is_admin) {
      echo " <li class='navigation-list-item'>
          <a href='user.php' class='navigation-list-item-link'>User</a></li>";
    } ?>
    <li class="navigation-list-item">
      <a href="./handle/logout.php" class="navigation-list-item-link" onclick="return logout(this)">logout</a>
    </li>
  </ul>
</div>