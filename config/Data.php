<?php

class Database
{
  private $__host = 'localhost';
  private $__db_name = 'bank';
  private $__username = 'root';
  private $__password = '';
  private $__connection;

  function connect()
  {
    $this->__connection = null;
    try {
      $this->__connection = new PDO('mysql:host=' . $this->__host . ';dbname=' . $this->__db_name, $this->__username, $this->__password);
      $this->__connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      // $this->__connection->exec('set names utf8');
      // echo "Connection Successfully";
      return $this->__connection;
    } catch (PDOException $e) {
      echo "Connection failed: " . $e->getMessage();
      $this->__connection = null;
    }
  }
}

class Data extends Database
{
  private $__start, $__rowPerPage, $__totalPages;
  private $_data = '';
  public $strPage = "";
  public $permissions = array();

  function getPermissions()
  {
    $this->permissions = $_SESSION['permissions'];
  }


  function readData($data)
  {
    $this->getPermissions();
    $str = '';
    $arr = array();
    $this->_data = $data;

    $connect = $this->connect();
    $_SESSION['currentPage'] = $currentPage = 1;
    $start = 0;
    $rowPerPage = 15;
    $total = $this->__totalPages;

    $_SESSION['pages'] = $pages = $total / $rowPerPage;

    if (isset($_GET['page'])) {
      $_SESSION['currentPage'] = $currentPage = $_GET['page'];
      $start = ($currentPage - 1) * $rowPerPage;
    }

    try {
      // count
      $statement = $connect->prepare($data);
      $statement->setFetchMode(PDO::FETCH_ASSOC);
      $statement->execute();
      $statement->fetchAll();

      $this->__totalPages = $statement->rowCount();
      $_SESSION['total'] = $this->__totalPages;

      $this->Navigation($this->__totalPages);

      $sql = $data . " ASC LIMIT $start, $rowPerPage ; ";
      $statement = $connect->prepare($sql);
      $statement->setFetchMode(PDO::FETCH_ASSOC);
      $statement->execute();
      $result = $statement->fetchAll();

      $account_number = 0;

      for ($i = 0; $i <= count($result) - 1; $i++) {
        $str .= "<tr>";
        foreach ($result[$i] as $key => $value) {
          if ($key == 'account_number') {
            $account_number = $value;
          }

          if ($key == 'gender') {
            $gender = $value == 'M' ? 'Male' : 'Female';
            $str .= " <td>" . $gender . "</td>";
          } else {
            $str .= " <td>" . $value . "</td>";
          }
        }
        foreach ($this->permissions as $permission) {
          if ($permission == 'update') {
            $str .= "<td><a href = '?page=$currentPage&account_number=$account_number' class = 'link-icon'>
            <i class='fi fi-sr-eye'></i></a></td> 
            <td><a href = './handle/delete.php?page=$currentPage&account_number=$account_number' onclick = 'return showMessageDelete(this)' class = 'link-icon'>
            <i class='red-color fa-solid fa-trash'></i></a></td>";
            $str .= "</tr>";
            break;
          }
        }
      }
      $arr[] = $str;
      $arr[] = $this->__totalPages;

      return $arr;

    } catch (PDOException $e) {
      echo "Error: " . $e->getMessage();
    }
  }

  function Navigation($total)
  {
    $rowPerPage = 15;
    $_SESSION['pages'] = $pages = $total / $rowPerPage;
    $_SESSION['start'] = 0;
    $index = 1;
    for ($index; $index <= $pages; $index++) {
      $this->strPage .= "<li>
      <a href = './?page=$index' class='content-navigation-link'> $index </a>
      </li>";
    }

    // $strPage .= "<a href = './?page=$index' class='content-navigation-link navigation-pre-next'> <i class='fa-solid fa-play'></i> </a>";

    $currentPage = 1;
    if (isset($_GET['page'])) {
      $currentPage = $_GET['page'];
      $_SESSION['start'] = ($currentPage - 1) * $rowPerPage;
    }
    $_SESSION['currentPage'] = $currentPage;
  }
}
?>