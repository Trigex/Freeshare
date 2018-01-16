function show_poll_answer_box()
{
	num_answers = $('#num_answers').val();
	
	if ( num_answers == "" || isNaN(num_answers) )
	{
		$('#num_answers').css('background-color','#ff0033');
	}
	else
	{
		$('#num_answers').css('background-color','#FFFFFF')
		for (i=0;i<num_answers;i++ )
		{
			var x=document.getElementById('poll_table_container').insertRow(0);
			var y=x.insertCell(0);
			var z=x.insertCell(1);
			y.innerHTML='Answer ' + (num_answers-i);
			z.innerHTML='<input type="text" size="40" name="poll_answer_' + i + '" id="poll_answer_' + i + '" onblur=poll_answer_validate("poll_answer_'+i+'","#EAEAEA","#FF0033")>';
		}
	}

}

function poll_answer_validate(myId,defaultColor,errColor)
{
	try
	{
		me=document.getElementById(myId);

		if (me.value == "")
		{
			me.style.background=errColor;
			me.setFocus;
			return false;
		}
		else
		{
			me.style.background=defaultColor;
			me.setFocus;
			return true;
		}
	}
	catch(Err)
	{
		return 'Err';
	}
}

function delete_poll_answer_box()
{
	var x = document.getElementById('poll_table_container').rows.length-1;

	for (var i=x;i>=0;i--)
	{
		document.getElementById('poll_table_container').deleteRow(i);
	}
}

function validate_poll_form()
{
	var flag = true;
	var is_valid = true;
	
	if ($('#poll_question').val() == '' )
	{
		$('#poll_question').css('background-color','#ff0033');
		is_valid = false;
	}
	var num_answers = $('#num_answers').val();

	if ( num_answers == "" || num_answers == 0 || isNaN(num_answers) )
	{
		$('#num_answers').css('background-color','#ff0033');
		is_valid = false;
	}

	var x = document.getElementById('poll_table_container').rows.length-1;

	for (i=x;i>=0;i--)
	{
		vote_answer_id = 'vote_answer_'+i;
		
		if ($('#vote_answer_id').val() == "")
		{
			$('#vote_answer_id').css('background-color','#FF0033');
			is_valid = false;
		}
	}
	
	if (is_valid == true)
	{
		return true;
	}
	else
	{
		return false;
	}
}

/*
 * -------------------------------------------------------------------------
 * poll edit
 * -------------------------------------------------------------------------
 */

function validate_poll_edit_form()
{
	var flag = true;
	var is_valid = true;
	
	if ($('#poll_question').val() == '' )
	{
		$('#poll_question').css('background-color','#ff0033');
		is_valid = false;
	}
	
	var x = document.getElementById('poll_table_container').rows.length-1;

	for (i=x;i>=0;i--)
	{
		vote_answer_id = 'vote_answer_'+i;
		
		if ($('#vote_answer_id').val() == "")
		{
			$('#vote_answer_id').css('background-color','#FF0033');
			is_valid = false;
		}
	}
	
	if (is_valid == true)
	{
		return true;
	}
	else
	{
		return false;
	}
}

function add_poll_ans()
{
	var num_ans = document.getElementById('ans');
	if (num_ans.value == '')
	{
		alert('Please enter number');
	} 
	var begining = document.getElementById('poll_begining');
	var ending = document.getElementById('poll_end');
	var after = document.getElementById('poll_after');
	
	if (begining.checked == true)
	{
		createTextElement(num_ans.value,'begining_text');
	} 
	else if (ending.checked == true)
	{
		createTextElement(num_ans.value,'ending_text');
	} 
	else if (after.checked == true) 
	{
		var after_position = document.getElementById('poll_select').value;
		createTextElement(num_ans.value,after_position);
	}
}

function createTextElement(inputNumber,divId)
{
	var elmentId = document.getElementById(divId);
	
	for(i=0;i<inputNumber;i++)
	{
		elm = document.createElement('input');
		elm.setAttribute('name','edit_poll_answers[]');
		elm.setAttribute('class','margin');
		elm.setAttribute('id','txtPollAnsQty');
		elmentId.appendChild(elm);
		nonSpacingBreak = document.createElement('br');
		elmentId.appendChild(nonSpacingBreak);
	}
}
