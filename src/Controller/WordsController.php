<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\WordCheck;

class WordsController extends AbstractController
{
    #[Route('/')]
    public function index(): Response
    {
        return $this->render('pages/index.html.twig', [
            'points' => '0',
        ]);
    }

    #[Route('/word', name: 'app_words', methods:['POST'])]
    public function postWord(HttpClientInterface $httpClient,WordCheck $wordCheck, $newWord): Response
    {
       $response = $httpClient->request('POST',
        'https://api.dictionaryapi.dev/api/v2/entries/en/', 
        ['body' => $newWord,]
        );

        if ($response->title === "No Definitions Found")
        {$response = "There is no such a word in English language";}
        else {
                   $points = 0;
                   $uniqueLettersPoints = count(array_unique(str_split($newWord)));
                   $palindromePoints = $wordCheck->checkIfPalindrome($newWord);
                   $almostPalindromePoints = null;
                    if (!$palindromePoints) {
                   $almostPalindromePoints = $wordCheck->checkIfAlmostPalindrome($newWord);
                   $points += $uniqueLettersPoints + $palindromePoints + $almostPalindromePoints;
                    }
        }

      return new Response('points:'.$points);
    }
}
