<?php

namespace GdprTools\Configuration;

interface TypeInterface
{

  /**
   * Returns the type name that can be used in the configuration.
   *
   * @return string
   */
  public static function name();

  /**
   * Returns anonymous content in this type's format.
   *
   * @param bool $unique
   * @param array $options
   *
   * @return mixed
   */
  public static function anonymise($unique = false, array $options = []);
}
