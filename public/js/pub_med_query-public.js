jQuery(function ($) {
	


	var apiKey = values.api_key;
	var researchers = values.researchers;
	var categories = values.categories;


	


	//only return initial results if user has entered api key and selected researchers
	if (apiKey && researchers.length != 0) {


		var count = 0;
		var retstart = 0;
		var retmax = 10;
		var currentPage = 1;
		var totalPages = 1;
		var urlBase = 'https://eutils.ncbi.nlm.nih.gov/entrez/eutils/esearch.fcgi';
		var authorList = [];
		var searchQuery;
		var url;


		researchers.forEach(function(researcher) {

			var formattedResearcher = formatResearcher(researcher);

			authorList.push(formattedResearcher);

		})

		authorList = authorList.join('+');
		searchQuery = authorList + '%5BAuthor%5D';
		url = urlBase + '?&term=' + searchQuery + '&retmode=json';



		//load initial results
		pubMedQuery(url);






	}//if api key && researchers







	function pubMedQuery(url) {

		console.log(url);

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

                            		

                            		$('#pub-med-container').append(
                            			'<div class="pub-med-article"><h5>'
                            			+ title
                            			+ '</h5><div>'
                            			);

                            	 })//foreach
                            	
                            });

	 		}//if ids are present

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




	function filterPubMed(){

		
	}



	$('.filter-articles').on('click', function(e){

		var filterVal = $('#researcher-select').val();

		if( filterVal == 'placeholder') {

			alert('Please select at least one researcher');

		} else {


			var researcher = formatResearcher(filterVal);

			searchQuery = researcher + '%5BAuthor%5D';
			url = urlBase + '?&term=' + searchQuery + '&retmode=json';

			$('#pub-med-container').empty();

			pubMedQuery(url);

		}
		

	})





});
