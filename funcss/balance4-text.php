
addsale( pr1, pr2, price1, price2, amount, type, user )
{
	add sale to salesTotal
	var1 = salesActive.highestId
	updatePair( pr1, pr2, user )
	updateActiveSales( var1 )
}


updatePair( pr1, pr2, user )
{
	var1 = showHowMuch( pr1, user )
	list1 = get salesTotal pr1 pr2 user list by price1 lowest first
	while( list1.next != null )
	{
		if( type == buy )
		{
			var2 = amount * price2
		}
		else
		{
			var2 = amount
		}
		if( var1 > var2 )
		{
			stock = var2
			var1 = var1 - stock
		}
		else
		{
			stock = var1
			var1 = 0
		}
		activeSale = get saleActive where totalId = id of this salesTotal
		if( exists )
		{
			if( stock == 0 )
				delete activeSale
			else
				update activeSale with ( stock )
		}
		if( not exists )
		{
			if( stock > 0 )
				new activeSale with ( thisSalesTotalId, stock )
		}
	}
}


updateActiveSales( stopId )
{
	currId = highedtId
	while( currId > stopId )
	{
		find match for currId
		if match found 
			currId = get highestId
		if match not found 
			currid = highest bid less than currId
	}
}


findMatch( fid )
{
	list1 = get from salesActive: product1 = fid.product2 and product2 = fid.product1 and 
								  price2 > fid.price1, order by price2 highest first
	var1 = fid.stock
	var2 = 0;
	while( list1.next != null && var1 > 0 )
	{
		var2 = var2 + balance2trades( fid, thisid )
	}

	return var2;
}


balance2trades( id1, id2 )
{
	var1 = some amount 1, what id1 sends id2
	var2 = some amount 2, what id2 sends id1
	
	sendproduct( id1.user, id2.user, var1, id1.pr1 )
	sendproduct( id2.user, id1.user, var2, id2.pr1 )

	updatesalesTotal( id1.totalId, id1.user )
	if( id1.type == sell )
	{
		update amount = amount - var1
	}
	if( id1.type == buy )
	{
		update amount = amount - var2
	}
	
	if( id2.type == sell )
	{
		update amount = amount - var2
	}
	if( id2.type == buy )
	{
		update amount = amount - var1
	}

	updateStock( id2.pr1, id1.user )
	updateStock( id1.pr1, id2.user )
	
	updateStock( id1.pr1, id1.user )
	updateStock( id2.pr1, id2.user )
	
	return 1
}


updateStock( pr1, user )
{
	list1 = get salesTotal pr1 user, list by pr2
	var2 = ""
	while( list1.next != null )
	{
		if( pr2 != var2 ) how in query
		{
			updatePair( pr1, pr2, user )
			var2 = pr2
		}
		else
		{
		}
	}
}




SELECT salesactive.uniqueX, saleID, salesactive.stock, sales3.uniqueX, amount1, type1, sales3.stock, creator1, product1, creator2, product2, price1, price2, user, dateTime, dateTime2
FROM `salesactive`
LEFT JOIN sales3 ON sales3.uniqueX = salesactive.saleID
LIMIT 0 , 30


















