<?php

namespace App\Service;

class WordCheck
{
    public function checkIfPalindrome($word)
   {
       if ($word === strrev($word)) {
           return 3;
       }
       return null;
   }

   public function checkIfAlmostPalindrome($word)
   {
       $length = strlen($word);
       for ($i = 0; $i <= $length; $i++) {
           $newWord = substr_replace($word, '', $i, 1);
           if ($newWord === strrev($newWord)) {
               return 2;
           }
       }
       return null;
   }
   
}
