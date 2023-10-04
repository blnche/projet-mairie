export function search () {
    let searchInput = document.getElementById('searchInput');
    
    
    let tableBody = document.getElementById('searchListItems');
    
    let tableTr = tableBody.getElementsByTagName('tr');
    //console.log(tableTr);
    
    
    searchInput.addEventListener('keyup', function () {
        let searchText = searchInput.value.toUpperCase();
        console.log(searchText);
        for (let i = 0; i < tableTr.length; i++) {
            
            let tdWeekNumber = tableTr[i].getElementsByTagName('td')[0];
            
            let text = tdWeekNumber.textContent || tdWeekNumber.innerText;
            
            if(text.toUpperCase().indexOf(searchText) > -1) {
                tableTr[i].style.display = "";
            } else {
                tableTr[i].style.display = "none";
            }
        }
    })
    
    
}