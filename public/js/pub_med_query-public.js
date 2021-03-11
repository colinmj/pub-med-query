(function( $ ) {
	'use strict';

	var apiKey = values.api_key;
	var researchers = values.researchers;


	//only return initial results if user has entered api key and selected researchers
	if (apiKey && researchers.length != 0) {

		var urlBase = 'https://eutils.ncbi.nlm.nih.gov/entrez/eutils/esearch.fcgi';

		var authorList = [];

		researchers.forEach(function(researcher) {

			var x = researcher.split('-').reverse().join('+');

			authorList.push(x);

		})

		authorList = authorList.join('+');


		var url = urlBase + '?&term=' + authorList + '%5BAuthor%5D&retmode=json';

		//var url = 'https://eutils.ncbi.nlm.nih.gov/entrez/eutils/esearch.fcgi?&term=Qiu+Wansu+Galea+Lisa%5BAuthor%5D&retmode=json';

		var count = 0;
		var retstart = 0;
		var retmax = 10;

		$.ajax({
			url: url,
			method: 'GET',
			dataType: 'json',
		})
		.then(function(data){

			count = data.esearchresult.count;
			var ids = data.esearchresult.idlist;

			if (count > retmax) {
				var button = document.getElementById('get-more');
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


})( jQuery );
