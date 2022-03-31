<?php

  class GetPets
  {
    function __construct()
    {
      global $wpdb;
      $tablename = $wpdb->prefix . 'pets';
      
      $this->args = $this->getArgs();
      $this->placeholders = $this->createPlaceholders();

      $query = "SELECT * FROM $tablename ";
      $query .= $this->createWhereText();
      $query .= " LIMIT 100";

      $this->pets = $wpdb->get_results($wpdb->prepare($query, $this->placeholders));
    }

    function getArgs() {
      $temporaryArray = array(
        'favcolor' => sanitize_text_field($_GET['favcolor']),
        'species' => sanitize_text_field($_GET['species']),
        'minyear' => sanitize_text_field($_GET['minyear']),
        'maxyear' => sanitize_text_field($_GET['maxyear']),
        'minweight' => sanitize_text_field($_GET['minweight']),
        'maxweight' => sanitize_text_field($_GET['maxweight']),
        'favhobby' => sanitize_text_field($_GET['favcolor']),
        'favfood' => sanitize_text_field($_GET['favcolor'])
      );

      return array_filter($temporaryArray, function($x) {
        return $x;
      });
    }

    function createPlaceholders() {
      return array_map(function($value) {
        return $value;
      }, $this->args);
    }

    function createWhereText() {
      $whereQuery = "";

      if (count($this->args)) {
        $whereQuery = "WHERE ";
      }

      $currentPosition = 0;
      foreach ($this->args as $key => $item) {
        $whereQuery .= $this->specificQuery($key);
        if ($currentPosition != count($this->args) -1) {
          $whereQuery .= " AND ";
        }
        $currentPosition++;
      }

      return $whereQuery;
    }

    function specificQuery($index) {
      switch ($index) {
        case "minweight":
          return "petweight >= %d";
          // break;
        case "maxweight":
          return "petweight <= %d";
          // break;
        case "minyear":
          return "birthyear >= %d";
          // break;
        case "maxyear":
          return "birthyear <= %d";
          // break;
        default:
          return $index . " = %s";
          // break;
      }
    }
  }
?>
  