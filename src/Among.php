<?php

namespace tartarus;

/**
 * This is the rev 502 of the Snowball SVN trunk,
 * now located at <a target="_blank" href="https://github.com/snowballstem/snowball/tree/e103b5c257383ee94a96e7fc58cab3c567bf079b">GitHub</a>,
 * but modified:
 * <ul>
 * <li>made abstract and introduced abstract method stem to avoid expensive reflection in filter class.
 * <li>refactored StringBuffers to StringBuilder
 * <li>uses char[] as buffer instead of StringBuffer/StringBuilder
 * <li>eq_s,eq_s_b,insert,replace_s take CharSequence like eq_v and eq_v_b
 * <li>use MethodHandles and fix <a target="_blank" href="http://article.gmane.org/gmane.comp.search.snowball/1139">method visibility bug</a>.
 * </ul>
 */
final class Among
{

    public function __construct(string $s, int $substring_i, int $result,
                                string $methodname, \ReflectionObject $methodobject)
    {
        $this->s_size = mb_strlen($s);
        $this->s = preg_split('//u', $s, -1, PREG_SPLIT_NO_EMPTY);
        $this->substring_i = $substring_i;
        $this->result = $result;
        if (empty($methodname)) {
            $this->method = null;
        } else {
            $clazz = $methodobject->getParentClass();
            if (!$clazz->isSubclassOf(SnowballProgram::class)) {
                throw new \RuntimeException(sprintf("Snowball program '%s' is broken, cannot access method: boolean %s()", $clazz->getShortName(), $methodname));
            }
//        $clazz = methodobject.lookupClass().asSubclass(SnowballProgram.class);
            try {
                $this->method = $clazz->getMethod($methodname);
//          $this->method = methodobject.findVirtual(clazz, methodname, MethodType.methodType(boolean.class))
//            .asType(MethodType.methodType(boolean.class, SnowballProgram.class));
            } catch (\ReflectionException $e) {
                throw new \RuntimeException(sprintf(
                    "Snowball program '%s' is broken, cannot access method: boolean %s()",
                    $clazz->getShortName(), $methodname
                ), 0, $e);
            }
        }
    }

    /** @var int */
    public $s_size; /* search string */
    /** @var string */
    public $s; /* search string */
    /** @var int */
    public $substring_i; /* index to longest matching substring */
    /** @var int */
    public $result;      /* result of the lookup */

    // Make sure this is not accessible outside package for Java security reasons!
    /** @var \ReflectionMethod MethodHandle */
    public $method; /* method to use if substring matches */

}