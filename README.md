# https-github.com-dr-matt-smith-evote-movie-2020-07-movie-class-loop

- declare a PHP class `Movie` 

    ```php
    <?php
    namespace Tudublin;
    
    class Movie
    {
        private $id;
        private $title;
        private $category;
        private $price;
        private $voteTotal;
        private $numVotes;
    
        public function getId()
        {
            return $this->id;
        }
    
        public function setId($id)
        {
            $this->id = $id;
        }
    
        public function getTitle()
        {
            return $this->title;
        }
    
        ... and so on - getters/setters for all properties ...
    ```
  
    - note we store number of votes `numVotes` and `voteTotal` making it easy to calculate the average vote
    
        - and also it will be easy to ADD a new vote, by adding to the total and incrementing `numVotes` ...

- add to class `Movie` method `getVoteAverage()`, which returns an integer average (total votes / num votes):

    ```php
    /**
     * @return int - integer average vote percentage
     *  (0..100)
     */
    public function getVoteAverage()
    {
        // avoid divide by zero problem ...
        if($this->numVotes < 1){
            return 0;
        }
        return intval($this->voteTotal / $this->numVotes);
    }
    ```

- add to class `Movie` a method `getStarImage()` which returns a star image name, based on the vote averge:

    ```php
    public function getStarImage()
    {
        if($this->getVoteAverage() > 85){
            return 'stars5.png';
        }
        if($this->getVoteAverage() > 70){
            return 'stars4.png';
        }
        if($this->getVoteAverage() >= 50){
            return 'stars3.png';
        }
        if($this->getVoteAverage() > 40){
            return 'stars2.png';
        }
        if($this->getVoteAverage() > 15){
            return 'stars1.png';
        }
    
        // if get here, less than 16%, so a half-star
        return 'starsHalf.png';
    }
    ```

- create a PHP class `MovieRepository` that has a single method `findAll()` that returns an array of `Movie` objects:

    ```php
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
    
            ... and so on 
    
            return $movies;
        }
    }
    ```

- edit method `listMovies()` in class `MainController` to get the array of `Movie` objects from a `MovieRepositry` object and pass this array as a variable to Twig when rendering the HTML:

    ```php
    public function listMovies()
    {
        $movieRepository = new MovieRepository();
        $movies = $movieRepository->findAll();
    
        $template = 'list.html.twig';
        $args = [
            'movies' => $movies
        ];
        $html = $this->twig->render($template, $args);
        print $html;
    }
    ```

- edit the movie list Twig template `/templates/list.html.twig` to loop through the array `movies`, using the getter values to populate each table row:

    ```twig
    {% for movie in movies %}
    <tr>
        <td>{{ movie.id }}</td>
        <td>{{ movie.title }}</td>
        <td>{{ movie.category }}</td>
        <td>&euro; {{ movie.price | number_format(2, '.', ',') }}</td>
        <td>{{ movie.voteAverage }} %</td>
        <td>{{ movie.numVotes }}</td>
        <td>
            {% if movie.numVotes > 0 %}
                <img src="images/{{ movie.starImage }}" alt="star image for percentage">
            {% else %}
                (no votes yet)
            {% endif %}
        </td>
    </tr>
    {% endfor %}
    ```
  
    - note the use of the Twig `number_format` function to ensure the pricfe is displayed to 2 decimal places `{{ movie.price | number_format(2, '.', ',') }}`
    
    - note the use of a Twig `if` statement, to display `(no votes yet)` if there are no values (total < 1), otherwise to dislay an HTML image element, whose source is `/images/` and the string image name from `Movie` object method `getStarImage()`