@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/route_de_vins.css') }}">

<div class="route_de_vins-container">
    <h1>Route des Vins</h1>

    <h2>Partir sur la route des vins</h2>

    <p>La route des vins est une route touristique qui vous plonge au cœur des régions viticoles, à la rencontre du vin bien sûr, des viticulteurs, du vignoble, mais 
        également de la gastronomie, du patrimoine culturel et des autres atouts touristiques régionaux. 
        Le développement de l’œnotourisme, en France et à l’international, a conduit à la création du concept de route des vins, qu’il ait été créé par des organismes 
        institutionnels du tourisme visant à mettre en avant une région viticole ou qu’il s’agisse simplement d’un circuit touristique recommandé par un guide.
        Cela reste une expérience de visite unique d’un vignoble permettant de concilier découverte du vin et exploration d’une région !
    </p>

    <h2>Les routes des vins en France</h2>
    <p>
        Les routes des vins sillonnent tous les vignobles français. Créées à partir des années 1950, ces itinéraires vous offrent l’opportunité unique de plonger,
         tête la première, au cœur d’une région viticole : découvertes œnologiques, culturelles et gastronomiques sont au programme.
        Aujourd’hui près de 7,5 millions d’oenotouristes* parcourent les vignobles chaque année : Français et étrangers, débutants et experts,
        tous les publics se retrouvent pour une balade de caves en caves, de dégustations de vins. De la plus connue comme <a href="/route_de_vins/4">la route des vins d'Alsace</a> 
         à la plus confidentielle, la plus longue à la plus brève, la plus ensoleillée à la plus fraîche, nous vous proposons un petit tour d’horizon 
        des routes des vins de France, à visiter ou à (re)visiter.
        Les itinéraires des routes des vins de France seront vous charmer, que cela soit en voiture, à pied ou à vélo ! 
    </p>

    <ul class="route_de_vins-liste">
        
        @foreach($routes_de_vins as $route_de_vins)
        <li class="route_de_vins-case">
            <img src="{{ asset('img/img_route_de_vins/'.$route_de_vins['img_route_de_vins']) }}" alt="">
            <h3 class="nom_route_de_vins">{{$route_de_vins['nom_route_de_vins']}}</h3>
            <ul class="description_route_de_vins">
                <li class ="description_route_de_vins">{{$route_de_vins['description_route_de_vins']}}</li>
            </ul>

            <button class="buttonDecouvrirRoute_de_vins"  onclick="location.href='{{ route('route_de_vins.showByNumRoute', ['num_route_de_vins' => $route_de_vins->num_route_de_vins]) }}'">Découvrir l'offre</button>
        @endforeach

    </ul>

    <h2>LES ACTIVITÉS INCONTOURNABLES</h2>

    <p>Tout au long de votre itinéraire, vous irez de vignobles en vignobles, d’appellations en appellations, pour déguster des vins, rencontrer 
        les vignerons et d’autres professionnels du monde viticole, visiter des musées ou des sites spécialisés liés à l’oenotourisme et à la viticulture.
         L’accueil dans les caves et caveaux ou 
        encore la participation à des ateliers œnologiques dans des propriétés viticoles feront partie des incontournables de votre parcours. 
        Sans oublier bien sûr de prendre le temps de savourer les produits du terroir ! Que cela soit le munster le long de la route des vins d'Alsace, 
        les escargots en Bourgogne ou encore les huîtres et la gastronomie bordelaise, parcourir les routes des vins de France, c'est poursuivre un émerveillement 
        de jour comme de nuit.
    </p>
    <h2>ORGANISER UN SÉJOUR SUR LA ROUTE DES VINS</h2>
    <p>
    VINOTRIP a construit pour vous des séjours et des circuits sur les routes des vins de France. 
    Vous pouvez également personnaliser, selon vos envies, vos itinéraires, que vous souhaitiez partir
     à la découverte du Champagne, de l’Alsace, de Bordeaux, du Languedoc-Roussillon, de la Bourgogne, 
     du Val de Loire, ... Les différentes étapes de votre parcours vous feront découvrir les coulisses 
     de la fabrication des vins de la région et vous entraîneront à la rencontre de nos partenaires passionnés, avides de vous 
    faire partager leur savoir. N'hésitez plus à réserver votre séjour oenologique si les routes des vins de France vous font 
    rêver.
    </p>
    
</div>
@endsection