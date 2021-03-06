<!DOCTYPE html>
<html>

    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Wyniki wyszukiwania zaawnsowanego - Rowerex - Rowerowy sklep internetowy</title>

        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link href="css/main.css" rel="stylesheet">
        <link href="css/search.css" rel="stylesheet">
		

    </head>

    <body>

        <?php include 'header.php'; ?>

        <!-- Page Content -->
        <div class="container">
            <div class="row">

                <?php include 'sidebar.php'; ?>

                <div class="col-md-9">
					<div class="panel panel-info">
					<form action="advanced_search.php" method="POST">
					<h3>Szukaj</h3>
					<div class="form-inline">
						<div class="form-group">
							<label for="exampleInputName2">Słowo(a):</label>
							<input name="words_input" type="text" class="form-control" id="exampleInputName2" placeholder="Wpisz słowa">
							<select name="type_search_content" class="form-control">
								<option value="1">Szukaj w tytułach</option>
								<option value="2">Szukaj zawartość postów</option>
							</select>
						</div>
					</div>
					<div class="form-inline">
						<div class="form-group">
							<label for="exampleInputName2">Tag:</label>
							<input name="tags_input" type="text" class="form-control" id="exampleInputName2" placeholder="Wpisz słowa" alt="Istnieje możliwość wpisania wielu tagów po przecinku lub spacji" />
						</div>
					</div>
					<h3>Dodatkowe opcje</h3>
					<div class="form-inline">
						<div class="form-group">
							<label for="exampleInputName2">Szukaj produktów po:</label>
							<select name="date_search" class="form-control">
								<option value="1">Obojętna data</option>
								<?php  // wywołanie opcji z wartością 2 pod warunkiem, że z wyszukiwarki korzysta zalogowany użytkownik
								
								if (isset($_SESSION['user']))
								{
								  echo '<option value="2">Od twojej ostatniej wizyty</option>';
								}
								?>
								<option value="3">Wczoraj</option>
								<option value="4">Tydzień temu</option>
								<option value="5">2 tygodnie temu</option>
								<option value="6">Miesiąc temu</option>
								<option value="7">3 miesięcy temu</option>
								<option value="8">Rok temu</option>
							</select>
							<select name="date_search_extension" class="form-control">
								<option value="1">i nowsze</option>
								<option value="2">i starsze</option>
							</select>
						</div>
					</div>
					<div class="form-inline">
						<div class="form-group">
							<label for="exampleInputName2">Sortuj po:</label>
							<select name="sort_by_type_content" class="form-control">
								<option value="1">Tytuł</option>
								<option value="2">Data</option>
							</select>
							<select name="sort_type" class="form-control">
								<option value="1">malejąco</option>
								<option value="2">rosnąco</option>
							</select>
						</div>
					</div>
					<div class="form-group">
						<center><button type="submit" class="btn btn-default">Szukaj teraz</button></center>
					</div>
				</form>
					<h3>Popularne tagi:</h3>
					<?php

			
				$a = new CIndex();

				$getTagsCloudArray1 = $a->GetTagsCloudsArray();
				
				/*
				$sth = $dbh->prepare("SELECT * 
										FROM (
										SELECT id_tag, name_tag, COUNT(id_tag) AS TagsCount 
										FROM products_has_tag
										NATURAL JOIN tag
										GROUP BY id_tag
										) AS TagsCountQuery
										ORDER BY TagsCount DESC
										LIMIT 25");
				$sth->execute();
				$results = $sth->fetchAll();
				
				*/
				
							
				echo '<form action="tag.php" method="POST"> 
							<div class="form-inline">
							<div class="form-group">';
							
				foreach($getTagsCloudArray1 as $result) 
				{
						echo '<button id="'.$result->m_sTagsClass.'" name="name_tag" type="submit" class="btn btn-default" value="'.$result->m_sTagName.'">'.$result->m_sTagName.'</button>';
				}
							
				echo '</div>
					</div>
				</form>'; ?>
			</div>
					
		<?php
                       
			function get_remote_data($url, $post_paramtrs = false) {
								
				$c = curl_init();
				curl_setopt($c, CURLOPT_URL, $url);
				curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
				
				if ($post_paramtrs) 
				{
					curl_setopt($c, CURLOPT_POST, TRUE);
					curl_setopt($c, CURLOPT_POSTFIELDS, "var1=bla&" . $post_paramtrs);
				} 
				
				curl_setopt($c, CURLOPT_SSL_VERIFYHOST, false);
				
				curl_setopt($c, CURLOPT_SSL_VERIFYPEER, false);
				curl_setopt($c, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.1; rv:33.0) Gecko/20100101 Firefox/33.0");
				curl_setopt($c, CURLOPT_COOKIE, 'CookieName1=Value;');
				curl_setopt($c, CURLOPT_MAXREDIRS, 10);
				$follow_allowed = ( ini_get('open_basedir') || ini_get('safe_mode')) ? false : true;
    
				if ($follow_allowed) 
				{
					curl_setopt($c, CURLOPT_FOLLOWLOCATION, 1);
				}
				curl_setopt($c, CURLOPT_CONNECTTIMEOUT, 9);
				curl_setopt($c, CURLOPT_REFERER, $url);
				curl_setopt($c, CURLOPT_TIMEOUT, 60);
				curl_setopt($c, CURLOPT_AUTOREFERER, true);
				curl_setopt($c, CURLOPT_ENCODING, 'gzip,deflate');
    
				$data = curl_exec($c);
				$status = curl_getinfo($c);
				curl_close($c);
				preg_match('/(http(|s)):\/\/(.*?)\/(.*\/|)/si', $status['url'], $link);
				$data = preg_replace('/(src|href|action)=(\'|\")((?!(http|https|javascript:|\/\/|\/)).*?)(\'|\")/si', '$1=$2' . $link[0] . '$3$4$5', $data);
				$data = preg_replace('/(src|href|action)=(\'|\")((?!(http|https|javascript:|\/\/)).*?)(\'|\")/si', '$1=$2' . $link[1] . '://' . $link[3] . '$3$4$5', $data);
    
				if ($status['http_code'] == 200) 
				{
					return $data;
				} 
				elseif ($status['http_code'] == 301 || $status['http_code'] == 302) 
				{
					if (!$follow_allowed) 
					{
						if (empty($redirURL)) 
						{
						
							if (!empty($status['redirect_url'])) 
							{
								$redirURL = $status['redirect_url'];
							}
						} 
						if (empty($redirURL)) 
						{
							preg_match('/(Location:|URI:)(.*?)(\r|\n)/si', $data, $m);
							if (!empty($m[2])) 
							{
								$redirURL = $m[2];
							}
						} 
						if (empty($redirURL)) 
						{
							preg_match('/href\=\"(.*?)\"(.*?)here\<\/a\>/si', $data, $m);
							if (!empty($m[1])) 
							{
								$redirURL = $m[1];
							}
						} 
						if (!empty($redirURL)) 
						{
							$t = debug_backtrace();
							return call_user_func($t[0]["function"], trim($redirURL), $post_paramtrs);
						}
					}
				} 
				
				return "ERRORCODE22 with $url!!<br/>Last status codes<b/>:" . json_encode($status) . "<br/><br/>Last data got<br/>:$data";
			}


			try{
					   					                  
                        if (isset($_POST['words_input']) && isset($_POST['type_search_content']) && isset($_POST['tags_input']) && isset($_POST['date_search']) && isset($_POST['date_search_extension']) && isset($_POST['sort_by_type_content']) && isset($_POST['sort_type']))  
						{

						/*SŁOWA*/
						
						// zapisanie listy wyrazów $_POST do zmiennej lokalnej
						
						$word_input = $_POST['words_input'];
						
						// określenie listy znaków które mają być zamienione na spację 
						$replace = array(",",";",".");
						
						// zamiana wyrazów, które występują w tablicy array na spację
						$word_input_replaced = str_replace($replace, " " , $word_input);						
						
						// splitowanie wyrazów z wykorzystaniem wyrażeń regularnych
						$word_input_split = preg_split("/[\s,!@#$%^\-=<>{}?_+]/", $word_input_replaced);
						
						/*
						echo "Słowo(a): ";
						
						foreach($word_input_split as $result)
						{
							echo $result.' ';
						}
						*/
						
						/*TAGI*/
						
						// zapisanie listy tagów $_POST do zmiennej lokalnej
						$tags_input = $_POST['tags_input'];
						
						// określenie listy znaków które mają być zamienione na spację - wykorzystam wcześniej
						// zdefiniowaną zmienną replace
						$tags_input_replaced = str_replace($replace, " ", $tags_input);
						
						// splitowanie wyrazów z wykorzystaniem wyrażeń regularnych
						
						$tags_input_split = preg_split("/[\s,!@#$%^\-=<>{}?_+]/", $tags_input_replaced);
						
						/*
						echo "<br />Tagi: ";
						
						foreach($tags_input_split as $result)
						{
							echo $result.' ';
						}
						*/
					
						// wyszukiwanie rzeczowników w wynikach wyszukiwania z wykorzystaniem sjp.pl
						/*
						foreach($word_input_split as $result)
						{
							$downloaded_url = get_remote_data('https://pl.wiktionary.org/wiki/'.$result);
							
							if(strpos($downloaded_url,'odmiana-rzeczownik'))
							{
								echo '<br />'.$result.' jest rzeczownikiem <br/>';
							}
							else if(strpos($downloaded_url,'<div style="border: 1px solid #ccc; padding: 7px; background: white;"><b>W Wikisłowniku nie ma jeszcze hasła pod taką nazwą. Masz do wyboru:</b>'))
							{
								$downloaded_url1 = get_remote_data('http://sjp.pl/'.$result);
								
								if(strpos($downloaded_url1,'<tr><th scope="row" valign="top"><tt>M') || strpos($downloaded_url1,'<tr><th scope="row" valign="top"><tt>U</tt></th><td>'))
								{
									echo '<br />'.$result.' jest rzeczownikiem <br/>';
								}
							}
						}
						
						*/
						
						
						echo '<h1>Wyniki wyszukiwania zaawansowanego:</h1>
						<div class="row">';
						
						$command_query_advanced_search = "SELECT * FROM Products p
														  JOIN products_has_tag AS ptt ON
														  p.id_product = ptt.id_product
														  JOIN tag AS t ON
														  t.id_tag = ptt.id_tag
														  JOIN category c ON
														  c.id_category = p.id_category
														  JOIN producer pr ON
														  pr.id_producer = p.id_producer 
														  WHERE ";
						
						// "SELECT * FROM Products WHERE name_product like ?"
						
						
						$count_words = 0;
						$x = 0;  // zmienna pomocnicza przy określaniu ile mamy słów w tablicy , przydatna przy stawianiu łączników AND
						
						foreach($word_input_split as $result)
						{
							if($result != "")
							{
								$count_words++;
								if($_POST['type_search_content'] == 1)
								{
										$x++;
										if( $x ==1 )
										{
											$command_query_advanced_search .= "p.name_product LIKE '%$result%'";
										}
										else 
										{
											$command_query_advanced_search .= " AND p.name_product LIKE '%result%' ";
										}
								}
								else if($_POST['type_search_content'] == 2)
								{
									$x++;
									if( $x ==1 )
									{
										$command_query_advanced_search .= "p.descriptions LIKE '%$result%'";
									}
									else 
									{
										$command_query_advanced_search .= " AND p.descriptions LIKE '%$result%'";
									}
								}
							}
						}
						
						$count_tags = 0;
						$x = 0; // zmienna pomocnicza przy określaniu ile mamy tagów w tablicy , przydatna przy stawianiu łączników AND
						
						foreach($tags_input_split as $result)
						{
							if($result != "")
							{
								$x++;
								$count_tags++;
								if( $x == 1 && $count_words == 0  )
								{
									$command_query_advanced_search .= "t.name_tag LIKE '%$result%'";
								}
								else
								{
									$command_query_advanced_search .= " AND t.name_tag LIKE '%$result%'";
								}
							}
							
							$count_tags++;
						}
						
						// wyszukiwanie dla zalogowanych użytkowników , np. szukanie produktów które zostały niedawno dodane
						
						if (isset($_SESSION['user'])) { // jedyny przypadek w wyszukiwaniu , gdzie jest potrzebny zalogowany użytkownik
						
							$sth = $dbh->prepare("SELECT date_last_logged FROM Client 
												  WHERE user_login =  ?");
							$var = array($_SESSION['user']);
							$sth->execute($var);
							$results = $sth->fetchAll();
						
							$date_last_logged = '';
							
							foreach($results as $result)
							{
								 $date_last_logged = $result['date_last_logged'];
							}
							
							if($_POST['date_search'] == 2 && ( $count_words || $count_tags )) // szukaj od twojej ostatniej wizyty
							{
								if($_POST['date_search_extension'] == 1)  // i nowsze
								{
									$command_query_advanced_search .= " AND p.date_add_products >= '$date_last_logged'";
								}
								else if($_POST['date_search_extension'] == 2) // i starsze
								{
									$command_query_advanced_search .= " AND p.date_add_products <= '$date_last_logged'";
								}
							}
						}
						
						// reszta warunków wyszukiwania spełni się niezależnie od tego czy z wyszukiwarki korzysta gość czy zalogowany użytkownik
							
							if($_POST['date_search'] == 1 && ( $count_words || $count_tags )) // obojętna data - czyli tak naprawdę wszystko
							{
								// wyszuka wszystkie niepotrzebny warunek
							}

							else if($_POST['date_search'] == 3 && ( $count_words || $count_tags )) // szukaj dodane wczoraj
							{
								if($_POST['date_search_extension'] == 1)  // i nowsze
								{
									$command_query_advanced_search .= " AND p.date_add_products >= SUBDATE(NOW(),1)";
								}
								else if($_POST['date_search_extension'] == 2) // i starsze
								{
									$command_query_advanced_search .= " AND p.date_add_products <= SUBDATE(NOW(),1)";
								}
							}
							else if($_POST['date_search'] == 4 && ( $count_words || $count_tags )) // szukaj dodane tydzień temu
							{
								if($_POST['date_search_extension'] == 1)  // i nowsze
								{
									$command_query_advanced_search .= " AND p.date_add_products >= NOW() - INTERVAL 1 WEEK";
								}
								else if($_POST['date_search_extension'] == 2) // i starsze
								{
									$command_query_advanced_search .= " AND p.date_add_products <= NOW() - INTERVAL 1 WEEK";
								}
							}
							else if($_POST['date_search'] == 5 && ( $count_words || $count_tags )) // szukaj dodane 2 tygodnie temu
							{
								if($_POST['date_search_extension'] == 1)  // i nowsze
								{
									$command_query_advanced_search .= " AND p.date_add_products >= NOW() - INTERVAL 2 WEEK";
								}
								else if($_POST['date_search_extension'] == 2) // i starsze
								{
									$command_query_advanced_search .= " AND p.date_add_products <= NOW() - INTERVAL 2 WEEK";
								}
							}
							else if($_POST['date_search'] == 6 && ( $count_words || $count_tags )) // szukaj dodane miesiąc temu
							{
								if($_POST['date_search_extension'] == 1)  // i nowsze
								{
									$command_query_advanced_search .= " AND p.date_add_products >= DATEADD(month, -1, GETDATE())";
								}
								else if($_POST['date_search_extension'] == 2) // i starsze
								{
									$command_query_advanced_search .= " AND p.date_add_products <= DATEADD(month, -1, GETDATE())";
								}
							}
							else if($_POST['date_search'] == 7 && ( $count_words || $count_tags )) // szukaj dodane 3 miesiące temu
							{
								if($_POST['date_search_extension'] == 1)  // i nowsze
								{
									$command_query_advanced_search .= " AND p.date_add_products >= DATEADD(month, -3, GETDATE())";
								}
								else if($_POST['date_search_extension'] == 2) // i starsze
								{
									$command_query_advanced_search .= " AND p.date_add_products <= DATEADD(month, -3, GETDATE())";
								}	
							}
							else if($_POST['date_search'] == 8 && ( $count_words || $count_tags )) // szukaj dodane rok temu
							{
								if($_POST['date_search_extension'] == 1)  // i nowsze
								{
									$command_query_advanced_search .= " AND p.date_add_products >= DATE_SUB(NOW(),INTERVAL 1 YEAR)";
								}
								else if($_POST['date_search_extension'] == 2) // i starsze
								{
									$command_query_advanced_search .= " AND p.date_add_products <= DATE_SUB(NOW(),INTERVAL 1 YEAR)";
								}	
							}
						
						
						// grupowanie po id produktu
						
						$command_query_advanced_search .= " GROUP BY p.id_product";
						
						// sortowanie 
						
						$command_query_advanced_search .= " ORDER BY ";
						
						if($_POST['sort_by_type_content'] == 1) // jeśli sortowanie po tytule 
						{
							$command_query_advanced_search .= " p.name_product "; // to wtedy dołączam do stringa zapytania sql name_product
							
							if($_POST['sort_type'] == 1)
							{
								$command_query_advanced_search .= " DESC"; // sortowanie malejąco
							}
							else if($_POST['sort_type'] == 2)
							{
								$command_query_advanced_search .= " ASC"; // sortowanie rosnąco
							}
						}
						else if($_POST['sort_by_type_content'] == 2) // jeśli sortowanie po dacie dodania produktu
						{
							$command_query_advanced_search .= " p.date_add_products "; // to wtedy dołączam do stringa zapytania sql date_add_products
							
							if($_POST['sort_type'] == 1)
							{
								$command_query_advanced_search .= " DESC"; // sortowanie malejąco
							}
							else if($_POST['sort_type'] == 2)
							{
								$command_query_advanced_search .= " ASC"; // sortowanie rosnąco
							}
						}
						
						/*
						// wyświetlenie złożonego zapytania 
						echo $command_query_advanced_search;
						*/
						
						$sth = $dbh->prepare($command_query_advanced_search);
						$sth->execute();
						$results = $sth->fetchAll();
						
								foreach($results as $result) { 


                                echo '<form id="name_form" method="POST" action="item.php">';
                                echo '<input name="id_product" type="text" style="display:none;" value="' . $result['id_product'] . '" />';
                                echo '
                                <div class="col-sm-4">
                                    <div class="box">
                                        <div class="image">
                                            <img src="' . $result['photography'] . '" class="img-responsive" alt="">
                                        </div>
                                        <div class="caption">
                                            <button>' . $result['name_product'] . '</button>
                                            <span class="price">' . $result['price_brutto'] . '</span>
                                            <div class="description">' . $result['descriptions'] . '</div>
                                        </div>
                                    </div>
                                </div>
                                ';
                                echo '</form>';
                            

                        
								}
						
							}

                        if (isset($_POST['id_category'])) {

						
							$sql1 = $dbh->prepare("SELECT description2 FROM Category WHERE id_category = :id_cat");
							$var1 = $_POST['id_category'];
							$sql1->execute(array(':id_cat' => $var1));
							$results1 = $sql1->fetchAll();
										
								
							
							foreach($results1 as $result) {
							
                            echo '<div class="col-sm-12" style="margin-bottom: 30px">' . $result['description2'] . '</div>';

							}
							
							
							
							$sth = $dbh->prepare("SELECT * FROM Products p
									 INNER JOIN Category c
									 ON c.id_category = p.id_category
									 WHERE c.id_category = :id_cat");
							$var = $_POST['id_category'];
							$sth->execute(array(':id_cat' => $var));
							$results = $sth->fetchAll();
							
                            foreach($results as $result) {



                                echo '<form id="name_form" method="POST" action="item.php">';
                                echo '<input name="id_product" type="text" style="display:none;" value="' . $result['id_product'] . '" />';
                                echo '
                                <div class="col-sm-4">
                                    <div class="box">
                                        <div class="image">
                                            <img src="' . $result['photography'] . '" class="img-responsive" alt="">
                                        </div>
                                        <div class="caption">
                                            <button>' . $result['name_product'] . '</button>
                                            <span class="price">' . $result['price_brutto'] . '</span>
                                            <div class="description">' . $result['descriptions'] . '</div>
                                        </div>
                                    </div>
                                </div>
                                ';
                                echo '</form>';
                            }

                        }
						
					 
					   }catch(Exception $e)
					   {
						   echo "Error. ".$e;
					   }
						
                        ?>

                    </div>
                </div>
            </div>
        </div>
        <!-- /.container -->
        <?php include 'footer.php'; ?>
    </body>
</html>