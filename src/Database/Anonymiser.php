<?php

namespace GdprTools\Database;

use GdprTools\Configuration\Configuration;
use GdprTools\Configuration\TypeFactory;
use Symfony\Component\Console\Style\SymfonyStyle;

class Anonymiser
{
  public function anonymise(Configuration $configuration, SymfonyStyle $io) {
    $this->anonymiseCustom($configuration, $io);
    $this->anonymisePreset($configuration, $io);
  }

  protected function anonymiseCustom(Configuration $configuration, SymfonyStyle $io) {
    if (!$configuration->isAvailable(['custom'])) {
      return;
    }

    $database = new Database($configuration, $io);
    $connection = $database->getConnection();

    $custom = $configuration->toArray()['custom'];
    if (!is_array($custom)) {
      $io->error('custom does not contain tables in the configuration.');
      return;
    }

    $tables = array_keys($custom);

    foreach ($tables as $table) {
      $columns = $custom[$table];

      if (!is_array($columns)) {
        $io->error($table . ' is does not contain columns in the configuration.');
        return;
      }

      foreach ($columns as $column => $type) {
        $typeObject = TypeFactory::instance()->create($type);

        if ($typeObject === null) {
          $io->error($type . ' type does not exist.');
          return;
        }

        $io->success($typeObject::name()); // debug message
      }
    }
  }

  protected function anonymisePreset(Configuration $configuration, SymfonyStyle $io) {
    if (!$configuration->isAvailable(['presets'])) {
      return;
    }
  }
}
