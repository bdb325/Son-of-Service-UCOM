$(document).ready(function(){
	
	// EVENT CAL
	if($('#event_cal').length){

		$('#event_cal').datepicker({
			showButtonPanel: true,
			onChangeMonthYear: function(year, month, inst){
				events.onChangeMonthYear(year, month, inst);
			},
			onRefresh: function(year, month, inst){
				events.onRefresh(year, month, inst);
			},
			beforeShowDay: function(date){
				return events.beforeShowDay($.datepicker.formatDate('mm-dd-yy', date));
			},
			onSelect:function(date,inst){
				date = date.replace(/\//g,"-");
				//hide every visible event that doesn't have class of d+date
				$('#event_list .event:not(.d'+date+'):visible').slideUp('fast');
				//show every non-visible event that has a class of d+date
				$('#event_list .event.d'+date+':hidden').slideDown('fast');
				
			},
			onTitleClick:function(year, month, inst){
				//show all the hidden events
				$('#event_list .event:hidden').slideDown('fast');
			}
		});

		//set the history stuff
		$.History.bind(function(hash){
			if(hash.length){
				d = hash.split("-");
				var date = new Date();
				date.setFullYear(d[0]);
				date.setMonth(d[1]-1, 1);
				date.setDate(1);

				//update the date picker
				$('#event_cal').datepicker('setDate', date);
			} else {
				// no hash means we are back to the first time of events
				// before we loaded the current months events so the user
				// is going back, so go back
				history.back();
			}
		});
	}

});


var events = {
	months: {},
	currentCalendar: {},
	emptyEventSelector: '#empty_event',
	eventListSelector: '#event_list',
	onChangeMonthYear: function(year, month, inst){

		if(!$.History.getState){
			$.History.setState(year+'-'+month);
		} else {
			$.History.setHash(year+'-'+month);
		}

		// if we don't already have the data get it
		if(this.months[year+''+month]==null)
			this._load(year, month, inst);
		else {
			// set the calendar and then refresh
			this.currentCalendar = this._exportCalendar(year, month);
			jQuery('#'+inst.id).datepicker('refresh');
		}
	},
	onRefresh: function(year, month, inst){
		//redraw the event calendar
		this._redrawList(year, month);
		jQuery('#made_dialog').remove();
	},
	beforeShowDay: function(date){
		//either return the currentCalendar date array or false
		if(this.currentCalendar[date])
			return this.currentCalendar[date];
		else
			return false;

	},
	// loads in the events using ajax
	_load: function(year, month, inst){
		var e = this;
	
		//load the data in with ajax
		$.ajax({
			url: 'ajax_events',
			data: {'year':year, 'month':month, 'rel':$('#event_cal').find('span.code').text()},
			dataType: 'json',
			beforeSend: function(){
				makeDialog('<div style="padding:10px 10px 0 10px; font-size:12px;text-align:center;"><img class="load_bar" src="layout_imgs/loading_bar.gif" alt="loading bar" /><p>loading events, please wait</p></div>','Loading Events',{},250,50,true);
			},
			success: function(json){
				// ajax_events will return false if there's no events in the month
				if(json){
					var m = [];
					$(json).each(function(){

						// FORMAT THE DATA PROPERLY
						this.date = new Date(this.event_date * 1000)
						this.calendar_month = $.datepicker.formatDate('M', this.date).toLowerCase();						

						//add the data to the month holder
						m.push(this);
					});
					e.months[year+''+month] = m;
				} else {
					e.months[year+''+month] = false;
				}

				//add the calendar data to this and refresh the datepicker
				e.currentCalendar = e._exportCalendar(year, month);
				jQuery('#'+inst.id).datepicker('refresh');
			},//end success
			error: function (XMLHttpRequest, textStatus, errorThrown) {
			  console.log(textStatus);
			  console.log(errorThrown);
			}
		});
	},
	_exportCalendar: function(year, month){
		calendar_info = {};
		
		//loop through the events for the month
		$(this.months[year+''+month]).each(function(){
			formatted_date = $.datepicker.formatDate('mm-dd-yy', this.date);

			if(calendar_info[formatted_date]){
				//add the title and category span
				calendar_info[formatted_date][2] =  calendar_info[formatted_date][2] + ", " + this.title;
				
				//first check to make sure we aren't doubling up on category markers
				var span = '<span class="category" style="background:#'+this.calendar_color+';"></span>';
				if(calendar_info[formatted_date][3].indexOf(span) == -1)
					calendar_info[formatted_date][3] = calendar_info[formatted_date][3] + span;

			} else {
				calendar_info[formatted_date] = [true, 'event', this.title, '<br /><span class="category" style="background:#'+this.calendar_color+';"></span>'];
			}
		});

		return calendar_info;

	},
	_redrawList: function(year, month){
		//make sure to empty out the event list
		var $event_list = jQuery(this.eventListSelector);
		$event_list.empty();
		//are there events in this month?
		if(this.months[year+''+month]){
			//setup a reference to this for the scope change in the loop				
			var e = this;
			//now loop through the events in the current month
			$(e.months[year+''+month]).each(function(){
				// touchup the title and time description to keep
				if(!this.title)
					this.title = "Untitled Event";
				if(!this.time || this.time=="false")
					this.time = "";

				var date_class = 'd'+jQuery.datepicker.formatDate('mm-dd-yy',this.date);

				// check if this event_id is already added to an event
				//if($('#e'+this.event_id, $event_list).length){
					// if there is already an event with the event id as a class
					// then add the date class so everything will still collapse properly
				//	$('#e'+this.event_id, $event_list).addClass(date_class);
				
				//} else {

					//clone and add data to the empty event  
					var event = jQuery(e.emptyEventSelector).clone().removeAttr('id').addClass(date_class).attr('id','e'+this.event_id).
					find('.calendar_color').
						css('background','#'+this.calendar_color).end().
					find('.title').
						html(this.title).end().				
					find('p.time').
						text(this.time).end().
					find('.day_calendar').
						addClass(this.calendar_month).append(jQuery.datepicker.formatDate('d',this.date)).end().
						find('.month').
							text(this.calendar_month).end();
			
				
					// repeat note
					if(this.repeat_description){
						event.find('p.repeats').html(this.repeat_description);
					} else {
						event.find('p.repeats').hide();
					}

					// address
					if(this.address){
						gmap_link = $(' <a href="http://maps.google.com/?q='+encodeURI(this.address)+'" title="google map link">map</a>');
						event.find('p.address').html(this.address).append(gmap_link);
					} else {
						event.find('p.address').hide();
					}
					
				
					// handle description
					if(this.description){
						//console.log($(event).find('.description'));
						$(event).find('.description').html(this.description);
					} else {
						$(event).find('.description').remove();
					}
			
					$event_list.append(event);
			
				//}	
			
			});
		} else {
			//notify that theres no events this month
			var msg = 'There are currently no events scheduled for this month. Please check back at a later date.';			
			jQuery('<div/>').addClass('error').append('<p><strong>'+msg+'</p></strong>').appendTo(this.eventListSelector);
		}
	},
	//can't _formatTime because of the scope within the ajax function in _load
	formatTime: function(time){
		if(!time)
			return false;

		time_parts = time.split(':');
		hours = time_parts[0];
		minutes = time_parts[1];	

		var suffix = "am";
		if(hours >= 12) {
			suffix = "pm";
			hours = hours - 12;
		}
		if(hours == 0) {
			hours = 12;
		}
		
		format_time = hours+':'+minutes+suffix;

		return format_time;
	}
};