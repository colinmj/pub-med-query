jQuery(function ($) {
	
	//var apiKey = values.api_key;
	var researchers = values.researchers;
	var categories = values.categories.split(',');
	var loadResults = values.load_results;
	var noResultsMessage = values.no_results;


	//only return initial results if user has entered api key and selected researchers
	//add api key back in here

	if (researchers.length != 0) {


		var count = 0;
		var retstart = 0;
		var retmax = 10;
		var currentPage = 1;
		var totalPages = 1;
		var urlBase = 'https://eutils.ncbi.nlm.nih.gov/entrez/eutils/esearch.fcgi';
		var authorList = [];
		var catList = [];
		var searchQuery;
		var url;

		//push all researchers with formatted name to array
		researchers.forEach(function(researcher) {

			var formattedResearcher = formatResearcher(researcher);

			authorList.push(formattedResearcher);

		});


		//if categories have been selected, push those to array
		if( categories.length != 0 ) {

			categories.forEach(function(cat) {
				catList.push(cat);
			})
		} 


		//if the category array is an empty string, set value to an empty string so it doesn't interfere with the query
		if( catList[0] == '') {
			catList = '';
		} else {
			catList = catList.join('+') + '[All Fields]';
		}
		

		authorList = authorList.join('+') + '[author]';
		searchQuery = authorList + '+' + catList;
		
		//changing this to not load categories on initial results

		url = urlBase + '?&term=' + authorList + '&retmode=json';



		//load initial results

		if( loadResults ) {

			pubMedQuery(url);

		}

		
	}//if api key && researchers


	function pubMedQuery(url) {

		$.ajax({
			url: url,
			method: 'GET',
			dataType: 'json',
		})
		.then(function(data){



			count = data.esearchresult.count;
			var ids = data.esearchresult.idlist;

			if (count > retmax) {

				var button = document.getElementById('load-more');
				totalPages = Math.ceil(count / retmax);

				if (totalPages > 1 && currentPage < totalPages ) {
					button.classList.add('visible');
					if (currentPage > 1) {
						button.removeEventListener('click', handleClick)
					}
					button.addEventListener('click', handleClick );
				} else {
					button.classList.remove('visible');
					button.removeEventListener('click', handleClick);
				}

	 		} //if count

	 		if( ids.length ){

	 			ids = ids.join(',').replace(/"|\s/gi, '');

	 			var url = 'https://eutils.ncbi.nlm.nih.gov/entrez/eutils/esummary.fcgi?db=pubmed';
                            //url += '&api_key=' + pubMedApi;
                            url += '&retmode=json&rettype=abstract&id=' + ids;

                            $.get(url).then(function (data) {

                            	if (!data && !data.result['uids']) return;

                            	data.result['uids'].forEach(function(uid){



                            		var title = data.result[uid]['title'];
                            		var pubDate = data.result[uid]['pubdate'];
                            		var journalName = data.result[uid]['fulljournalname'];
                            		var authors = '';
                            		var link = 'https://pubmed.ncbi.nlm.nih.gov/' + data.result[uid]['uid'];


                            		data.result[uid]['authors'].forEach(function(author) {

                            			displayAuthor = '<span>' + author.name + ', </span> ';
                            			authors += displayAuthor;


                            		})

                            		
                            		

                            		$('#pub-med-container').append(

                            			'<div class="pub-med-query--article"><h5>'
                            			+ '<a target="_blank" href="'
                            			+ link
                            			+ '">'
                            			+ title
                            			+ '</a></h5>'
                            			+ '<div class="pub-med-query--journal-authors">'
                            			+ authors
                            			+'</div>'
                            			+ '<p class="pub-med-query--journal-name">'
                            			+ journalName
                            			+ '</p>'
                            			+ '<p>'
                            			+ pubDate
                            			+ '</p>'
                            			+ '</div>'
                            			);

                            	 })//foreach
                            	
                            });

                        } else {

                        	if( noResultsMessage != '' ) {

                        		$('#pub-med-container').append(

                        			'<div><h5>' + noResultsMessage + '</h5></div>'

                        			);

                        	}

                        	
                        }

                    });

	}





	function handleClick (e) {
		e.preventDefault();
		currentPage ++;
		retstart += retmax;

		var nextPage = urlBase +  '?&term=' + searchQuery + '&retstart=' + retstart + '&retmode=json';

		pubMedQuery(nextPage);
	}


	function formatResearcher(researcher) {

		return researcher.split('-').reverse().join('+');
	}



	$('.filter-articles').on('click', function(e){

		var researcherVal = $('#researcher-select').val();

		if( researcherVal == 'placeholder') {

			alert('Please select at least one researcher');

		} else {



			var researcher = formatResearcher(researcherVal);
			var categoryVal = $('#category-select').val();
			var selectedDate;

			

			if( categoryVal == 'placeholder') {
				catQuery = '';
			} else {
				catQuery = categoryVal + '[All Fields]';
			}

			searchQuery = researcher + '[author]' + '+' + catQuery;
			url = urlBase + '?&term=' + searchQuery + '&retmode=json';

			$('#pub-med-container').empty();

			pubMedQuery(url);

		}
		

	})





});
