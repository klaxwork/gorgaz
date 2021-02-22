/**
 *
 * Быстрый поиск элемента в массиве объектов по свойству элемента
 *
 * findInObjects(arr, 'name', value);
 * вернет элемент, в котором element[name] = value
 *
 * findInObjects(arr, value);
 * вернет элемент, в котором element.id = value
 *
 *
 * @param arr -- массив объектов или массивов
 * @param field -- поле, по которому нужно искать
 * @param value -- значение, которое должно быть в поле
 * @returns {boolean}
 */
function findInObjects(arr, field, value) {
	if (value == undefined) {
		value = field;
		field = 'id';
	}
	for (var i = 0, l = arr.length; arr[i] && arr[i][field] !== value; i++) {
	}
	return i === l ? false : arr[i];
}

/**
 * делает то же, что и предыдущая функция,
 * но в отличие от предыдущей функции вернет не только объект
 * а массив с индексом и самим искомым объектом
 *
 * @param arr
 * @param field
 * @param value
 * @returns {boolean}
 */
function findInObjects2(arr, field, value) {
	if (value == undefined) {
		value = field;
		field = 'id';
	}
	for (var i = 0, l = arr.length; arr[i] && arr[i][field] !== value; i++) {
	}
	var x = {};
	x.index = i;
	x.element = arr[i];
	return i === l ? false : x;
}

function saveToLog(data) {
	console.log('[DATA]', data);
	$.ajax({
		url: 'index.php?r=site/log',
		type: 'POST',
		dataType: 'json',
		data: data
	});
	alert('saveToLog');
}

/**
 * функция возвращает копию объекта, без учета функций, если таковые имелись
 * @param arr Array()
 * @returns arr2 Array()
 */
function copy(arr) {
	var arr2 = [];
	for (var index in arr) {
		var type = typeof arr[index];
		if (type === 'function') {
			continue;
		}
		if (type === 'array' || type === 'object') {
			arr2[index] = {};
			arr2[index] = copy(arr[index]);
		}
		if (type === 'string' || type === 'number') {
			arr2[index] = arr[index];
		}
	}
	return arr2;
}

/**
 * Функция удаляет из массивов все элементы, имеющиеся в обоих массивах
 * и возвращает массив оставшихся элементов
 * arr[0] = left;
 * arr[1] = right;
 * @param left
 * @param right
 * @returns {*}
 */
function diffArrays(left, right) {
	var arr1 = copy(left);
	var arr2 = copy(right);
	var pos;
	var index;
	//удаляем из первого массива все, что есть во втором
	for (index in arr2) {
		var elem2 = arr2[index];
		pos = arr1.indexOf(elem2);
		if (pos > -1) {
			delete arr2[index];
			delete arr1[pos];
		}
	}
	//удаляем из второго массива все, что есть в первом
	for (index in arr1) {
		var elem1 = arr1[index];
		pos = arr2.indexOf(elem1);
		if (pos > -1) {
			delete arr1[index];
			delete arr2[pos];
		}
	}
	var arr = [];
	arr[0] = array_values(arr1);
	arr[1] = array_values(arr2);
	return arr;
}


function compareArrays(arr1, arr2) {
	arr1.sort();
	arr2.sort();

	for (var index in arr2) {
		pos = arr1.indexOf(arr2[index]);
	}

	return arr;
}


/**
 * функция array_values возвращает только значения массива, без ключей
 *
 * @param input
 * @returns {Array}
 */
function array_values(input) {
	//
	// +   original by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)

	var tmp_arr = new Array(), cnt = 0;

	for (var key in input) {
		tmp_arr[cnt] = input[key];
		cnt++;
	}

	return tmp_arr;
}


/**
 * проверка объекта на пустоту
 * @param obj
 * @returns {boolean}
 */
function empty(obj) {
	for (var i in obj) {
		if (obj.hasOwnProperty(i)) {
			return false;
		}
	}
	return true;
}

function getAllData(from, to) {
	var type = 'dxTextBox';
	var dxBox = $('<div>')[type]({
		//items: [{'id': 1, 'value': 'one'},{'id':2, 'value':'two'}],
		//values: [1,2],
		//displayExpr: 'value',
		//valueExpr: 'id'

	});
	console.log('[dxBox]', dxBox);
	var dxBoxinst = dxBox[type]('instance');
	dxBoxinst.option('getValueField', 'text');
	console.log('[dxBoxinst]', dxBoxinst);
	dxBoxinst.option('value', '12/12/2012');
	var x = dxBoxinst.option('text');
	console.log('[x]', x);


	return false;
	;


	for (var index in from) {
		var obj = from[index];
		console.log('[' + index + ']', from[index]);
		if (from[index].option === undefined) {
			console.log('UNDEFINED');
		}


		//console.log('[TYPEOF]', typeof from[index].option);
		if (typeof obj === 'object') {
			if (typeof obj.option === 'function') {
				to[index] = obj.option('value');
			}
		}


	}
}

function implode(glue, pieces) {
	return ( ( pieces instanceof Array ) ? pieces.join(glue) : pieces );
}

function print_r(array, return_val) {
	var output = "", pad_char = " ", pad_val = 4;

	var formatArray = function (obj, cur_depth, pad_val, pad_char) {
		if (cur_depth > 0)
			cur_depth++;

		var base_pad = repeat_char(pad_val * cur_depth, pad_char);
		var thick_pad = repeat_char(pad_val * (cur_depth + 1), pad_char);
		var str = "";

		if (typeof obj == 'object' || typeof obj == 'array' || (obj.length > 0 && typeof obj != 'string' && typeof obj != 'number')) {
			if (!(typeof obj == 'object' || typeof obj == 'array'))str = '\n' + obj.toString() + '\n';
			str += '[\n';//"Array\n" + base_pad + "(\n";
			for (var key in obj) {
				if (typeof obj[key] == 'object' || typeof obj[key] == 'array' || (obj.length > 0 && typeof obj != 'string' && typeof obj != 'number')) {
					str += thick_pad + "" + key + ": " + ((!(typeof obj == 'object' || typeof obj == 'array')) ? '\n' + obj[key] + '\n' : '') + formatArray(obj[key], cur_depth + 1, pad_val, pad_char) + '\n';
				} else {
					str += thick_pad + "" + key + ": " + obj[key] + "\n";
				}
			}
			str += base_pad + "]\n";
		} else {
			str = obj.toString();
		}

		return str;
	};

	var repeat_char = function (len, char) {
		var str = "";
		for (var i = 0; i < len; i++) {
			str += char;
		}
		return str;
	};

	output = formatArray(array, 0, pad_val, pad_char);
	return output;
}

var $month = ['Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь', 'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь'];

var $ofmonth = ['Января', 'Февраля', 'Марта', 'Апреля', 'Мая', 'Июня', 'Июля', 'Августа', 'Сентября', 'Октября', 'Ноября', 'Декабря'];

var $dayweek = ['Воскресенье', 'Понедельник', 'Вторник', 'Среда', 'Четверг', 'Пятница', 'Суббота', 'Воскресенье'];

function Month(date) {
	var arr = [];
	arr[0] = getFullYear(date);
	arr[1] = getMonth(date);
	arr[2] = getDate(date);
	arr[3] = getHours(date);
	arr[4] = getMinutes(date);
	arr[5] = getSeconds(date);

}

function OfMonth() {

}

function DayOfWeek() {

}

//уведомление
function notify(header, text, type) {
	var head = $('<span>')
		.css({
			'color': '#000000',
			'font-size': '20px'
		})
		.text(header)
		.append('<br>');
	var color = '#ff0000';
	if (type == "success") {
		color = '#bbffbb';
	} else if (type == "warning") {
		color = '#ffbbbb';
	}
	$('.notify').remove();
	var noti = $('.notify-template').clone().removeClass('notify-template').addClass('notify');
	noti.find('.inner-notify').css({'background-color': color}).html(head).append(text);
	$('body').prepend(noti);
}

function extend() {
	var res = [];
	for (var argc in arguments) {
		for (var i in arguments[argc]) {
			res[i] = $.extend(res[i], Object(arguments[argc][i]));
		}
	}
	return res;
}

/**
 *
 * @param type [success, warning, danger]
 * @param title
 * @param text
 */
function pnotify(type, title, text, delay) {
	//console.log(type, title, text);
	// Create new Notification
	if (delay == undefined) {
		delay = 3000;
	}
	new PNotify({
		title: title,//'jQuery UI Icon Error',
		text: text, //'Oh no. Something\'s wrong with your network, and I\'m showing you visually using an appropriate
					// icon to indicate the type of error that has occured. You know, network.',
		type: type, //'error',
		//icon: 'ui-icon ui-icon-signal-diag',
		delay: delay
	});
}

$(document).ready(function () {
	$('.quotes').on('mouseleave focusout', function () {
		var $value;
		$value = $(this).val();
		if ($value[0] == '"') {
			$value[0] = '«';
		}
		$value = $value.replace(' "', ' «').replace('" ', '» ').replace('"', '»');
		$(this).val($value);
	});
});

function printr(value, variable) {
	console.log('[' + variable.toUpperCase() + ']:', value);
}


