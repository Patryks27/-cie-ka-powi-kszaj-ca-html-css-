
<!DOCTYPE html>
<html>

    <head>
        <script src="Queue.src.js"></script>
        <meta charset="utf-8">
		 <link rel="stylesheet" href="main2.css" type="text/css">
        <title>Zadanie grafy</title>
        <script>
            function Oblicz(a,b)
            {
                
                var ekran =document.getElementById("wynik_algorytmu");
                // n - liczbę wierzchołków w grafie sieci
                // m - liczbę krawędzi
                var n = a;
                var m = b;
                let kolejka = new Queue();
                
                var esc = false;
                
                var cp=0;
                
                var c = [];
                var f = [];
                // P   - poprzedniki na ścieżkach tworzonych przez BFS
                // CFP - przepustowość ścieżek
                var p = [];
                var cfp =[];
                
                //wejscie/wyjscie
                var s=document.getElementById("id_pole_wejscie").value;
                var t=document.getElementById("id_pole_wyjscie").value;
                
                for(i=0;i<n;i++)
                    {
                        c[i] = [];
                        f[i] = [];
                    }
                
                  for(i=0; i<n; i++ )  // Zerujemy macierze przepustowości i przepływów
                      {
                        for(j=0;j<n;j++ ) 
                        {
                            c[i][j] = 0;
                            f[i][j] = 0;
                        }
                      }

                for(i=0;i<m;i++){
                    for(j=0;j<3;j++)
                        {
                            var box_od =document.getElementById("id_w"+i+"_0");
                            var box_do =document.getElementById("id_w"+i+"_1");
                            var box_waga =document.getElementById("id_w"+i+"_2");
                            c[box_od.value][box_do.value]= box_waga.value;
                            //alert(box.value);
                        }
                }
                //famx maksymalny przepływ
                var fmax =0;
            while(true)
                {
                    for( i = 0; i < n; i++ )
                        {
                            p[i]=-1;
                        }
                    p[s] = -2;
                    cfp[s]=Infinity;
                    while(kolejka.isEmpty() == false)
                        {
                            kolejka.dequeue();
                        }
                    kolejka.enqueue(s);
                    esc = false;

                    while(kolejka.isEmpty() == false)
                        {
                            let x = kolejka.dequeue();

                            for(y = 0; y < n; y++ )
                                {
                                    cp = c[x][y] - f[x][y];
                                    if(cp!=0 && p[y]==-1)
                                        {
                                            p[y]=x;
                                        if(cfp[x]>cp)
                                            {
                                                cfp[y]=cp;
                                            }
                                         else{
                                                cfp[y]=cfp[x];
                                            }
                                           if(y==t)//nie wchodzi
                                              {
                                                    fmax +=cfp[t];
                                                    i=y;
                                                    while(i!=s)
                                                        {
                                                            x=p[i];
                                                            f[x][i] +=cfp[t];
                                                            f[i][x] -=cfp[t];
                                                            i=x;
                                                        }
                                                    esc = true;
                                                    break;
                                               }
                                            kolejka.enqueue(y);
                                        }
                                }
                            if(esc==true)
                                {
                                    break;
                                }
                        }
                    if(esc==false)
                        {
                            break;
                        }
                }

                
                var wynik="Maksymalny przepływ: "+fmax+"<br>";
                for( x = 0; x < n; x++ )
                    {
                        for( y = 0; y < n; y++ )
                            {
                                if(c[x][y]!=0)
                                    {
                                        wynik+= x+" -> " +y+ " "+f[x][y]+":"+c[x][y]+" <br>";
                                    }
                            }
                    }

                ekran.innerHTML = wynik;
                
            }
            function Sprawdz_tex_box()
            {
                var w =document.getElementById("id_wierzcholski"); //sprawdzamy pole wierzchołków
                var w_txt = w.value;
                var error =document.getElementById("bledy");
                const firstForm = document.querySelector("form");
                wyrazenie = /^[\d]{1,}$/g;
                if (!wyrazenie.test(w_txt))
                    {
                        
                        error.innerHTML="To nie jest liczba!";
                        return false;
                    }
                if(w_txt>99)
                    {
                        error.innerHTML="Maksymalna ilość wierzchołków 99!";
                        return false;
                    }
                
                w =document.getElementById("id_krawedzi");//sprawdzamy poe krawędzi
                w_txt = w.value;
                wyrazenie = /^[\d]{1,}$/g;
                if (!wyrazenie.test(w_txt))
                    {
                        error.innerHTML="To nie jest liczba!";
                        return false;
                    }
                if(w_txt>99)
                    {
                        error.innerHTML="Maksymalna ilość krawędzi 99!";
                        return false;
                    }

                return true;
            }
            
            function Sprawdz_macierz(x,y)
            {
                document.getElementById("wynik_algorytmu").innerHTML=""; //czyście ekran, wcześniejsze wyniki
                var wyrazenie1 =/^[\d]{1,2}$/g;
                var error =document.getElementById("bledy_macierz");
                for(i=0;i<y;i++){
                    for(j=0;j<3;j++)
                        {
                            if(j==2)
                                {
                                    var box =document.getElementById("id_w"+i+"_"+j);
                                    wyrazenie1 =/^[\d]{1,}$/g;
                                    if(box.value=="") //sprawdzanie czy nie puste
                                        {
                                             error.innerHTML="Nie wypełniono wszystkich pól!";
                                            return false;
                                        }
                                     if (!wyrazenie1.test(box.value)) //sprawdzanie czy liczby ieszczą sie w przedziale
                                    {
                                        error.innerHTML="Nie wprowadzono liczby do wagi krawędzi";
                                        return false;
                                    }
                                }
                            else
                                {
                                    var box =document.getElementById("id_w"+i+"_"+j);
                                    wyrazenie1 =/^[\d]{1,2}$/g;
                                    if(box.value=="") //sprawdzanie czy nie puste
                                        {
                                             error.innerHTML="Nie wypełniono wszystkich pól!";
                                            return false;
                                        }
                                     if (!wyrazenie1.test(box.value)) //sprawdzanie czy liczby ieszczą sie w przedziale
                                    {
                                        error.innerHTML="Do pól można wprowadzać tylko cyfry od 0 do 99!";
                                        return false;
                                    }
                                    if(box.value>=x) //sprawdzamy czy podany wierzchołek nie jeste większy od zadeklarowanej wartości
                                        {
                                            error.innerHTML="Nr wierzchoła w liście jest większy od zadeklarowanej ilości!";
                                            return false;
                                        }
                                }

                        }
                }
                var box =document.getElementById("id_pole_wejscie"); //sprawdzanie pół wejscia i wyjścia 
                wyrazenie = /^[\d]{1,2}$/g;
                if (!wyrazenie.test(box.value))
                    {
                        error.innerHTML="Do pola wejście nie wprowadzono liczby!";
                        return false;
                    }
                else{
                    if(box.value>=x)
                        {
                            error.innerHTML="Nr wierzchołka wejscia jest większy od zadeklarowanej ilości!";
                            return false;                            
                        }
                    }
                
                box =document.getElementById("id_pole_wyjscie");
                wyrazenie = /^[\d]{1,2}$/g;
                if (!wyrazenie.test(box.value))
                    {
                        error.innerHTML="Do pola wyjście nie wprowadzono liczby!";
                        return false;
                    }
                else{
                    if(box.value>=x)
                        {
                            error.innerHTML="Nr wierzchołka wyjście jest większy od zadeklarowanej ilości!";
                            return false;                            
                        }
                    }
                error.innerHTML="";
                //alert("ok1");
                Oblicz(x,y);
            }
        </script>
        
    </head>
    <body>
        <div class="mainConteiner">
            <div class="project">
                <?php
                  if(isset($_GET["ilosc_wierzcholkow"])&& $_GET["ilosc_wierzcholkow"]!="" && isset($_GET["ilosc_krawedzi"])&& $_GET["ilosc_krawedzi"]!="")
                  {
                      $ilosc_w=$_GET["ilosc_wierzcholkow"];
                      $ilosc_k=$_GET["ilosc_krawedzi"];
                    ?>
                        <div><p><b>Podaj liste krawędzi grafu oraz przepustowość</b></p> </div>
                        <!--<form action="http://127.0.0.1/index.php" method="get">-->
                        <div class="field_info">
                            Od
                        </div>
                        <div class="field_info">
                            Do
                        </div>
                        <div class="field_info" id="field_przep">
                            Przepustowość
                        </div>
                        <br>
                    <?php

                      for($i=0; $i<$ilosc_k;$i++)
                      {
                            for($j=0; $j<3;$j++)
                            {
                                ?>
                                 <input type="text" class="text" name="w<?php echo($i)?>_<?php echo($j)?>" id="id_w<?php echo($i)?>_<?php echo($j)?>"/>    
                                <?php
                                    if($j==0)
                                    {
                                        ?>
                                        -->
                                        <?php
                                    }
                                    if($j==1)
                                    {
                                        ?>
                                        waga:
                                        <?php
                                    }
                            }
                            Echo("</br>");                  
                          }
                            ?>
                                Źródło: <input type="text" class="text" id="id_pole_wejscie">
                                Ujście:<input type="text" class="text" id="id_pole_wyjscie">
                                <br>
                            <?php
                          echo'<button class="button_project" onclick="Sprawdz_macierz('; echo $ilosc_w; echo ","; echo $ilosc_k; echo ')">Oblicz</button> </form>
                          ';
                        ?>
                            <button class="button_project" id="button_back" onclick="BackMain()">Powrót na główną</button>
                            <script>
                                function BackMain()
                                {
                                    location.href="http://grafyprojektpatrykjakub.epizy.com/";
                                }
                            </script>
                            <button class="button_project" id="button_back" onclick="pryzklad()">Przykład</button>
                            <script>
                                function pryzklad()
                                {
                                    location.href="http://grafyprojektpatrykjakub.epizy.com/?ilosc_wierzcholkow=7&ilosc_krawedzi=11&przyklad=1";
                                }
                            </script>
                            <?php
                                if(isset($_GET["przyklad"]))
                                {
                                    if($_GET["przyklad"]==1)
                                    {
                                    ?>
                                    <script>
                                       var tab =[[0,1,7],[0,3,3],[1,3,4],[1,4,6],[2,0,9],[2,5,9],[3,4,9],[3,6,2],[5,3,3],[5,6,6],[6,4,8]];
                                        for(i=0;i<11;i++){ //uzupełniamy pola przykłądowymi danymi
                                                var box_od =document.getElementById("id_w"+i+"_0");
                                                box_od.value=tab[i][0];
                                                var box_do =document.getElementById("id_w"+i+"_1");
                                                box_do.value=tab[i][1];
                                                var box_waga =document.getElementById("id_w"+i+"_2");
                                                box_waga.value=tab[i][2];
  
                                            }
                                        document.getElementById("id_pole_wejscie").value=2;
                                        document.getElementById("id_pole_wyjscie").value=4;
                                    </script>
                                    <?php
                                    }

                               }
                            ?>
                            <div id="bledy_macierz" class="info_blad"></div>
                            <div id="wynik_algorytmu"></div>
                            <div class="author">
                                <div id="authorInfo">
                                    <p>
                                        <b>Autorzy:</b> <br>
                                        &nbsp &nbsp Patryk Stępień <br>
                                        &nbsp &nbsp Jakub Podsiadły

                                    </p>
                                </div>
                            </div>

                        <?php
                  }
                    else{

                    ?>
                        <form action="http://grafyprojektpatrykjakub.epizy.com/" onsubmit="return Sprawdz_tex_box()" method="get">
                            <p>Ilość wierzchołków:<br></p>
                            <input type="text" class="text" name="ilosc_wierzcholkow" id="id_wierzcholski"><br>
                            <p>Ilość krawędzi:</p>
                            <input type="text" class="text" name="ilosc_krawedzi" id="id_krawedzi"><br>
                            <button type="submit"  class="button_project" value="Submit">Dalej</button>
                            <button type="button" class="button_project" id="button_prz" onclick="pryzklad()">Przykład</button>
                            <script>
                                function pryzklad()
                                {
                                    location.href="http://grafyprojektpatrykjakub.epizy.com/?ilosc_wierzcholkow=7&ilosc_krawedzi=11&przyklad=1";
                                }
                            </script>
                            <div id="bledy" class="info_blad"></div>
                            <div id="instruction">
                                <p> <i>* W ilość wierzchołków podajemy ilość wierzchołków grafu wraz z wierzchołkiem źródła i ujścia.<br> 
                                    &nbsp W polu ilość krawędzi podajemy ilość krawędzi grafu.<br>
                                    &nbsp Wierzchołki są numerowane od <b>0</b> do <b>n-1</b> gdzie n - zadeklarowana ilość wierzchołków.<br>
                                    </i>
                                </p>
                            </div>
                        </form>       
                    <?php
                    }
                ?>
                <div id="ekran">
                </div>
            </div>
        </div>
    </body>
</html>

