<?php


namespace Tudublin;


class MovieRepository
{
    public function findAll()
    {
        $movies = [];

        $m1 = new Movie();
        $m1->setId(1);
        $m1->setTitle('Jaws');
        $m1->setCategory('thriller');
        $m1->setPrice(10.00);
        $m1->setVoteTotal(5);
        $m1->setNumVotes(1);
        $movies[] = $m1;

        $m2 = new Movie();
        $m2->setId(2);
        $m2->setTitle('Jaws II');
        $m2->setCategory('thriller');
        $m2->setPrice(5.99);
        $m2->setVoteTotal(77 * 90);
        $m2->setNumVotes(77);
        $movies[] = $m2;

        $m3 = new Movie();
        $m3->setId(3);
        $m3->setTitle('Shrek');
        $m3->setCategory('comedy');
        $m3->setPrice(10);
        $m3->setVoteTotal(5 * 50);
        $m3->setNumVotes(5);
        $movies[] = $m3;

        $m4 = new Movie();
        $m4->setId(4);
        $m4->setTitle('Shrek II');
        $m4->setCategory('comedy');
        $m4->setPrice(4.99);
        $m4->setVoteTotal(0);
        $m4->setNumVotes(0);
        $movies[] = $m4;
        
        $m5 = new Movie();
        $m5->setId(5);
        $m5->setTitle('Alien');
        $m5->setCategory('scifi');
        $m5->setPrice(19.99);
        $m5->setVoteTotal(95 * 201);
        $m5->setNumVotes(201);
        $movies[] = $m5;

        return $movies;
    }

}