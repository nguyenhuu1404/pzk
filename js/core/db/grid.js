PzkCoreDbGrid = PzkObj.pzkExt({
	page: 0,
	gridFocus: false,
	init: function() {
		var that = this;
		$(document).ready(function() {
	        $('#selecctall').click(function(event) {
	            if(this.checked) {
	                $('.grid_checkbox').each(function() {
	                    this.checked = true;
						$(this).change();
	                });
	            }else{
	                $('.grid_checkbox').each(function() {
	                    this.checked = false;
						$(this).change();
	                });
	            }
	        });

	        $('#griddelete').click(function(){
	            var allVals = that.getSelecteds();

	            if(allVals.length > 0){
	                var r = confirm("Bạn có muốn xóa không?");
	                if (r == true) {
	                    $.ajax({
	                        type: "POST",
	                        url: BASE_REQUEST + "/admin_"+that.module+"/delAll",
	                        data:{ids:JSON.stringify(allVals)},
	                        success: function(data) {
	                            if(data ==1) {
	                                that.changePage(that.page);
	                            }

	                        }
	                    });
	                }
	            }else {
	                alert('Bạn hãy chọn bảng ghi muốn xóa!');
	            }

	            return false;
	        });

	        $('#exportdata').click(function() {
	            var r = confirm("Bạn có muốn export không?");
	            if (r == true) {
	            	$('#fromexport').submit();
	            }
	            return false;
	        });
	        if(that.autoRefresh) {
				setInterval(function(){
					if(!that.page)
						that.changePage(0);
				}, that.autoRefreshTimeInterval || 60000);	
			}
	        
	        $('#commandlineForm').find('[name=commandline]').focus();
			setTimeout(function(){
				that.reload();
				that.checkDisplaySidebar();
				that.checkDisplayNavbar();
				that.checkDisplayNavigation();
				that.checkDisplayPadding();
				that.commandLineSubmit();
				that.documentShortcuts();
				that.checkSorters();
				that.checkCtrlClick();
			}, 100);			
	    });
	},
	checkSorters: function() {
		var that = this;
		for(var i = 0; i < that.listFieldSettings.length; i++) {
			var fieldSettings = that.listFieldSettings[i];
			var field = fieldSettings.index;
			this.checkSorter(field);
		}
	},
	documentShortcuts: function() {
		var that = this;
		$('#admin_table_list').mouseover(function(){
			that.gridFocus = true;
		});
		
		$('#admin_table_list').mouseout(function(){
			that.gridFocus = false;
		});
		$(document).keydown(function(evt) {
			if(evt.ctrlKey && evt.keyCode == 107) {
				evt.preventDefault();
				window.location = BASE_REQUEST + '/admin_' + that.module + '/add';
			}
			if(!that.inlineFocus && that.gridFocus && evt.ctrlKey && evt.keyCode == 37) {
				evt.preventDefault();
				if(that.page > 0)
					that.changePage(that.page - 1);
			}
			if(!that.inlineFocus && that.gridFocus && evt.ctrlKey && evt.keyCode == 39) {
				evt.preventDefault();
				that.changePage(that.page + 1);
			}
		});
	},
	reload: function() {
		var that = this;
		for(var i = 0; i < that.listFieldSettings.length; i++) {
			var fieldSettings = that.listFieldSettings[i];
			var field = fieldSettings.index;
			if(fieldSettings.type == 'ordering') {
				that.reloadOrdering(field);
			}
			that.checkDisplay(field);
		}
		that.reloadRowClicking();
		that.checkDisplayPadding();
		that.checkCtrlClick();
		that.checkToggleRows();
		//that.verify();
	},
	checkToggleRows: function() {
		var fieldIndex = 'directory-open';
		var col = 'grid-column-' + this.id + '-' + this.module + '-' + fieldIndex;
		var savedOpens = window.sessionStorage.getItem(col);
		if(!savedOpens) {
			savedOpens = {};	
		} else {
			savedOpens = JSON.parse(savedOpens);
		}
		for(var k in savedOpens) {
			if(!savedOpens[k]) {
				this.toggleRow(k);
			}
		}
	},
	checkCtrlClick: function() {
		$('.ctrl-click').click(function(e){
			if (e.ctrlKey || e.metaKey) {
				e.preventDefault();
				var ctrlClick = $(this);
				var url = ctrlClick.data('ctrllink');
				console.log(url);
				setTimeout(function(){
					window.location = url;
				},100);
				
				return false;
			}
		});
	},
	reloadRowClicking: function() {
		var that = this;
		$('#admin_table_list tbody tr').click(function(){
			if(that.quickMode) {
				var id= $(this).find('.grid_checkbox').val();
				if(id)
					that.detail(id);
			} else {
				var chb = $(this).find('input[type=checkbox]');
				chb.prop('checked', !chb.prop('checked'));
				chb.change();	
			}
			
		});
		if(0) {
			$('#admin_table_list tbody tr').dblclick(function(){
				var a = $(this).find('.glyphicon-edit').parent();
				var href = a.prop('href');
				if(that.dblclickedMode && that.dblclickedMode == 'detail') {
					href = href.replace('edit', 'detail');
				}
				
				window.location = href;
			});
		}
		$('.grid_checkbox').change(function() {
			var tr = $(this).parent().parent();
			if(this.checked) {
				tr.addClass('success');
			} else {
				tr.removeClass('success');
			}
		});
	},
	reloadOrdering: function(field) {
		$('input[name^='+field+']').keyup(function(evt){
			if(evt.keyCode == 40) {
				var next = $(this).parents('tr').next().find('input[name^='+field+']:first');
				if(next.length) {
					next.focus();
					next.select();
				}
			} else if(evt.keyCode == 38) {
				var prev = $(this).parents('tr').prev().find('input[name^='+field+']:first');
				if(prev.length) {
					prev.focus();
					prev.select();
				}
			}
		});
	},
	saveOrdering: function(field) {
		var that = this;
		var inputs = $('input[name^='+field+']');
		var orderings = {};
		$.each(inputs, function(index, input) {
			var val = $(input).val();
			var id = $(input).attr('rel');
			orderings[id] = val;
		});
		$.ajax({url: '/admin_'+ that.module + '/saveOrderings', type: 'post', data: {orderings: orderings, field: field}, success: function() { that.changePage(0); }});
	},
	saveRowOrdering: function (id, field) {
		var that = this;
		var inputOrdering = $('#' + field + '_' + id);
		var value = inputOrdering.val();
		$.ajax({
			url: '/admin_'+ that.module + '/saveOrderings', 
			type: 'post', 
			data: {
				id: id, 
				field: field,
				value: value
			}, 
			success: function(resp) { 
				if(!resp) {
					alert('Không lưu được');
				}
			}
		});
	},
	performAction: function() {
		var action = $('#gridAction').val();
		if(!!action) {
			var allVals = this.getSelecteds();
			if(allVals.length > 0){
				var r = confirm("Bạn có muốn thực hiện lệnh này không?");
				if (r == true) {
					$.ajax({
						type: "POST",
						url: BASE_REQUEST + "/admin_"+that.module+"/" + action,
						data:{ids:JSON.stringify(allVals)},
						success: function(data) {
							if(data ==1) {
								window.location.href = '/admin_'+that.module+'/index';
							}

						}
					});
				} else {
					$('#gridAction').val('');
				}
			}else {
				alert('Bạn hãy chọn bảng ghi muốn xóa!');
			}
		} else {
			alert('Bạn chưa chọn hành động nào');
		}
	},
	getSelecteds: function() {
		var allVals = [];
		$('.grid_checkbox:checked').each(function() {
			allVals.push($(this).val());
		});
		return allVals;
	},
	getAll: function() {
		var allVals = [];
		$('.grid_checkbox').each(function() {
			allVals.push($(this).val());
		});
		return allVals;
	},
	changeStatus: function(field, id, elem) {
		$.ajax({
			type: "POST",
			url: BASE_REQUEST + "/admin_"+this.module+"/changeStatus",
			data:{id:id, field: field, isAjax: true},
			success: function(data) {
				if(data ==1) {
					$(elem).css('color', 'blue');
				} else {
					$(elem).css('color', 'black');
				}
			}
		});
	},
	search: function (keyword) {
		var that = this;
		if(that.keyword == keyword) return false;
		that.keyword = keyword;
		$.ajax({
			type: "POST",
			url: BASE_REQUEST + "/admin_"+this.module+"/search",
			data:{keyword: keyword, isAjax: true},
			success: function(data) {
				that.changePage(0);
			}
		});
		
	},
	workflow: function(field, id, value, elem) {
		$.ajax({
			type: "POST",
			url: BASE_REQUEST + "/admin_"+this.module+"/workflow",
			data:{id:id, field: field, value: value, isAjax: true},
			success: function(data) {
				if(data) {
					$(elem).html(data);
				} else {
					alert('Bạn không có quyền thay đổi');
				}
			}
		});
	},
	changePage: function (page) {
		var that = this;
		that.page = page;
		var postData = {page: page, isAjax: true};
		if(that.parentMode) {
			postData.parentMode = that.parentMode || null;
			postData.parentField = that.parentField || null;
			postData.parentId = that.parentId || null;	
		}
		
		$.ajax({
			type: "POST",
			url: BASE_REQUEST + "/admin_"+this.module+"/index",
			data: postData,
			success: function(data) {
				if(data) {
					$('#admin_table_'+that.id + ' tbody').html(data);
					that.reload();
				} else {
					alert('Bạn không có quyền thay đổi');
				}
			}
		});
		
	},
	changePageSize: function(pageSize) {
		var that = this;
		$.ajax({
			type: "POST",
			url: BASE_REQUEST + "/admin_"+this.module+"/changePageSize",
			data:{pageSize: pageSize, isAjax: true},
			success: function(data) {
				that.changePage(0);
			}
		});
	},
	changeView: function(view) {
		var that = this;
		$.ajax({
			type: "POST",
			url: BASE_REQUEST + "/admin_"+this.module+"/changeView",
			data:{view: view, isAjax: true},
			success: function(data) {
				that.changePage(0);
			}
		});
	},
	changeColumns: function(columns) {
		var that = this;
		$.ajax({
			type: "POST",
			url: BASE_REQUEST + "/admin_"+this.module+"/changeColumns",
			data:{columns: columns, isAjax: true},
			success: function(data) {
				that.changePage(0);
			}
		});
	},
	changeOrderBy: function(orderBy) {
		var that = this;
		$.ajax({
			type: "POST",
			url: BASE_REQUEST + "/admin_"+this.module+"/changeOrderBy",
			data:{orderBy: orderBy, isAjax: true},
			success: function(data) {
				that.changePage(0);
			}
		});
	},
	filter: function(type, index, value) {
		var that = this;
		$.ajax({
			type: "POST",
			url: BASE_REQUEST + "/admin_"+this.module+"/filter",
			data:{type: type, index: index, select: value, isAjax: true},
			success: function(data) {
				that.changePage(0);
			}
		});
	},
	toogleDisplay: function(fieldIndex) {
		var col = 'grid-column-' + this.id + '-' + this.module + '-' + fieldIndex;
		if(!!window.sessionStorage.getItem(col)) {
			window.sessionStorage.removeItem(col);
		} else {
			window.sessionStorage.setItem(col, '1');
		}
		this.checkDisplay(fieldIndex);
	},
	checkDisplay: function(fieldIndex){
		var col = 'grid-column-' + this.id + '-' + this.module + '-' + fieldIndex;
		if(!!window.sessionStorage.getItem(col)) {
			$('.column-header-' + fieldIndex).hide();
			$('.column-' + fieldIndex).hide();
			$('.column-toogle-' + fieldIndex).removeClass('glyphicon-remove-circle');
			$('.column-toogle-' + fieldIndex).addClass('glyphicon-ok-circle');
		} else {
			$('.column-header-' + fieldIndex).show();
			$('.column-' + fieldIndex).show();
			$('.column-toogle-' + fieldIndex).removeClass('glyphicon-ok-circle');
			$('.column-toogle-' + fieldIndex).addClass('glyphicon-remove-circle');
		}
	},
	toogleSidebar: function() {
		var fieldIndex = 'sidebar-toogle-display';
		var col = 'grid-column-' + this.id + '-' + this.module + '-' + fieldIndex;
		if(!!window.sessionStorage.getItem(col)) {
			window.sessionStorage.removeItem(col);
		} else {
			window.sessionStorage.setItem(col, '1');
		}
		this.checkDisplaySidebar();
	},
	checkDisplaySidebar: function(){
		var fieldIndex = 'sidebar-toogle-display';
		var col = 'grid-column-' + this.id + '-' + this.module + '-' + fieldIndex;
		if(!!window.sessionStorage.getItem(col)) {
			$('#right').hide();
			$('#left').width('100%');
			$('.btn-sidebar-action-label').text('Hiện sidebar');
		} else {
			$('#right').show();
			$('#left').width('80%');
			$('.btn-sidebar-action-label').text('Ẩn sidebar');
		}
	},
	toogleNavbar: function() {
		var fieldIndex = 'navbar-toogle-display';
		var col = 'grid-column-' + this.id + '-' + this.module + '-' + fieldIndex;
		if(!!window.sessionStorage.getItem(col)) {
			window.sessionStorage.removeItem(col);
		} else {
			window.sessionStorage.setItem(col, '1');
		}
		this.checkDisplayNavbar();
	},
	checkDisplayNavbar: function(){
		var fieldIndex = 'navbar-toogle-display';
		var col = 'grid-column-' + this.id + '-' + this.module + '-' + fieldIndex;
		if(!!window.sessionStorage.getItem(col)) {
			$('#navbarForm').hide();
			$('.btn-navbar-action-label').text('Hiện navbar');
		} else {
			$('#navbarForm').show();
			$('.btn-navbar-action-label').text('Ẩn navbar');
		}
	},
	commandLineSubmit: function() {
		var that = this;
		$('#commandlineForm').submit(function(evt){
			var inp = $(evt.target).find('[name=commandline]');
			var command = inp.val();
			that.executeCommandLine(command);
			inp.val('');
			return false;
		});
	},
	toggleNavigation: function () {
		var fieldIndex = 'navigation-toggle-display';
		var col = 'grid-column-' + this.id + '-' + this.module + '-' + fieldIndex;
		if(!!window.sessionStorage.getItem(col)) {
			window.sessionStorage.removeItem(col);
		} else {
			window.sessionStorage.setItem(col, '1');
		}
		this.checkDisplayNavigation();
	},
	checkDisplayNavigation: function() {
		var fieldIndex = 'navigation-toggle-display';
		var col = 'grid-column-' + this.id + '-' + this.module + '-' + fieldIndex;
		if(!!window.sessionStorage.getItem(col)) {
			$('#grid-nav').hide();
			$('#grid-list').removeClass('col-sm-10').addClass('col-sm-12');
		} else {
			$('#grid-nav').show();
			$('#grid-list').removeClass('col-sm-12').addClass('col-sm-10');
		}
	},
	togglePadding: function () {
		var fieldIndex = 'padding-display';
		var col = 'grid-column-' + this.id + '-' + this.module + '-' + fieldIndex;
		if(!!window.sessionStorage.getItem(col)) {
			window.sessionStorage.removeItem(col);
		} else {
			window.sessionStorage.setItem(col, '1');
		}
		this.checkDisplayPadding();
	},
	checkDisplayPadding: function() {
		var fieldIndex = 'padding-display';
		var col = 'grid-column-' + this.id + '-' + this.module + '-' + fieldIndex;
		if(!!window.sessionStorage.getItem(col)) {
			$('#admin_table_list td, #admin_table_list th').css('padding', '0px');
		} else {
			$('#admin_table_list td, #admin_table_list th').css('padding', '8px');
		}
	},
	executeCommandLine: function(command) {
		var that = this;
		$.ajax({
			type: "POST",
			url: BASE_REQUEST + "/admin_"+this.module+"/command",
			data:{command: command, isAjax: true},
			success: function(response) {
				eval('response = ' + response + ';');
				$('#commandlineResult').text(response.text);
				if(response.action) {
					eval(response.action);
				}
			}
		});
	},
	orderByIndexes: {},
	orderBys: {},
	toggleOrderBy: function (index) {
		this.orderByIndexes[index] = (1 + (this.orderByIndexes[index] || 0)) % 3;
		if(this.orderByIndexes[index] == 0) {
			delete this.orderBys[index];
		} else {
			this.orderBys[index] = PzkCoreDbGrid.orderBys[this.orderByIndexes[index]];
		}
		
		var that = this;
		$.ajax({
			type: "POST",
			url: BASE_REQUEST + "/admin_"+this.module+"/orderBys",
			data:{orderBys: that.orderBys, isAjax: true},
			success: function(data) {
				that.checkSorter(index);
				that.changePage(0);
			}
		});
	},
	checkSorter: function(index) {
		var that = this;
		$('.column-sorter-' + index).removeClass('glyphicon-chevron-up');
		$('.column-sorter-' + index).removeClass('glyphicon-chevron-down');
		if(that.orderByIndexes[index] && that.orderByIndexes[index] == 1) {
			$('.column-sorter-' + index).addClass('glyphicon-chevron-up');
		} else if(that.orderByIndexes[index] && that.orderByIndexes[index] == 2) {
			$('.column-sorter-' + index).addClass('glyphicon-chevron-down');
		} else {
			// do nothing
		}
    },
    updateMutiSelect: function(frm, field, type) {
        var data = $(frm).serializeForm();
        var that = this;
        var allVals = this.getSelecteds();
        if(allVals.length > 0){
            var r = confirm("Bạn có muốn cập nhật không?");
            if (r == true) {
                $.ajax({
                    type: "POST",
                    url: BASE_REQUEST+"/admin_"+that.module+"/updateOneField",
                    data:{ids:JSON.stringify(allVals), data:data, field:field, type:type},
                    success: function(data) {
                        if(data ==1) {
                            that.changePage(that.page);
                        }

                    }
                });
            }
        }else {
            alert('Vui lòng chọn bảng ghi muốn cập nhật!');
        }

        this.changePage(this.page);
    },
    updateSelect: function(frm, field, type) {
        var data = $(frm).serializeForm();
        var that = this;
        var allVals = that.getSelecteds();

        if(allVals.length > 0){
            var r = confirm("Bạn có muốn cập nhật không?");
            if (r == true) {
                $.ajax({
                    type: "POST",
                    url: BASE_REQUEST+"/admin_"+that.module+"/updateOneField",
                    data:{ids:JSON.stringify(allVals), data:data, field:field, type:type},
                    success: function(data) {
                        if(data ==1) {
                            that.changePage(that.page);
                        }

                    }
                });
            }
        }else {
            alert('Vui lòng chọn bảng ghi muốn cập nhật!');
        }

        return false;
    },
	updateDataTo: function(frm) {
		var data = $(frm).serializeForm();
		var that = this;
		var allVals = that.getSelecteds();

		if(allVals.length > 0){
			var r = confirm("Bạn có muốn cập nhật không?");
			if (r == true) {
				$.ajax({
					type: "POST",
					url: BASE_REQUEST+"/admin_"+that.module+"/updateDataTo",
					data:{ids:JSON.stringify(allVals), data:data},
					success: function(data) {
						if(data ==1) {
							that.changePage(that.page);
						}

					}
				});
			}
		}else {
			alert('Vui lòng chọn bảng ghi muốn cập nhật!');
		}

		return false;
	},
	dialog: function(id, url) {
		var that = this;
		if(!url) {
			url = BASE_REQUEST + "/admin_"+this.module+"/dialog";
		}
		$.ajax({
			type: "POST",
			url: url,
			data:{id: id, isAjax: true},
			success: function(response) {
				$('#dialog .modal-body').html(response);
				$('#dialog').modal({show: true});
				$('#dialog').find('form').submit(function(){
					
					var $form = $(this);
					var url = $form.attr('action');
					var formData = $(this).serializeForm();
					$.ajax({
						url: url,
						data: formData,
						type: 'post',
						success: function(resp) {
							$('#dialog').modal('hide');
							that.changePage(that.page);
						}
					});
					return false;
				});
			}
		});
	},
	detail: function(id) {
		var that = this;
		$.ajax({
			type: "POST",
			url: BASE_REQUEST + "/admin_"+this.module+"/view/" + id,
			data:{id: id, isAjax: true},
			success: function(response) {
				$('#grid-detail').html(response);
			}
		});
	},
	verify: function() {
		var that = this;
		var ids = that.getAll();
		$.ajax({
			type: "POST",
			url: BASE_REQUEST + "/admin_"+this.module+"/verify",
			data:{ids: ids, isAjax: true},
			success: function(response) {
				if(response) {
					eval('response = ' + response + ';');
					$.each(response, function(index, row) {
						if(row.error) {
							$('#row-' + row.id).addClass('label-danger');
						} else if(row.warning) {
							$('#row-' + row.id).addClass('label-warning');
						}
						var title = $('#row-' + row.id).attr('title');
						if(!title) {
							$('#row-' + row.id).attr('title', row.message);
						} else {
							if(title.indexOf(row.message) === -1){
								$('#row-' + row.id).attr('title', title + ', ' + row.message);
							}
						}
						$('#row-' + row.id).tooltip();
					});
					
				}
			}
		});
	},
	showInlineEdit: function(field, id) {
		$('#inline-item-'+field+'-'+id).find('.inline-input').show();
		$('#inline-item-'+field+'-'+id).find('.inline-input input').width($('#inline-item-'+field+'-'+id).find('.inline-text').width());
		$('#inline-item-'+field+'-'+id).find('.inline-text').hide();
		$('#inline-item-'+field+'-'+id).find('.inline-input input').focus();
	},
	saveInlineEdit: function(field, id) {
		var that = this;
		var value = $('#inline-item-'+field+'-'+id).find('.inline-input input').val();
		$.ajax({
			type: "POST",
			url: BASE_REQUEST + "/admin_"+that.module+"/inlineEditPost",
			data:{id: id, field: field, value: value, isAjax: true},
			success: function(response) {
				that.changePage(that.page);
			}
		});
		
	},
	cancelInlineEdit: function(field, id) {
		$('#inline-item-'+field+'-'+id).find('.inline-input').hide();
		$('#inline-item-'+field+'-'+id).find('.inline-text').show();
	},
	toggleRow: function(id) {
		var that = this;
		var rows = $('.row-parent-' + id);
		var $row = $('#row-' + id);
		var rowChildrenHidden = $row.data('childrenHidden');
		if(rowChildrenHidden) {
			that.saveOpenDirectory(id);
			$row.data('childrenHidden', false);
			$('#row-toggle-btn-'+id).html('<span class="glyphicon glyphicon-folder-open"></span>');
		} else {
			that.saveCloseDirectory(id);
			$row.data('childrenHidden', true);
			$('#row-toggle-btn-'+id).html('<span class="glyphicon glyphicon-folder-close"></span>');
		}
		$.each(rows, function(index, row) {
			var $row = $(row);
			var rowId = $row.attr('rel');
			var rowHidden = $row.data('hidden');
			if(rowHidden) {
				that.setRowHidden(rowId, false);
			} else {
				that.setRowHidden(rowId, true);
			}
		});
		that.checkDisplayRows();
	},
	saveOpenDirectory: function(id) {
		var fieldIndex = 'directory-open';
		var col = 'grid-column-' + this.id + '-' + this.module + '-' + fieldIndex;
		var savedOpens = window.sessionStorage.getItem(col);
		if(!savedOpens) {
			savedOpens = {};	
		} else {
			savedOpens = JSON.parse(savedOpens);
		}
		savedOpens[id] = true;
		window.sessionStorage.setItem(col, JSON.stringify(savedOpens));
	},
	saveCloseDirectory: function(id) {
		var fieldIndex = 'directory-open';
		var col = 'grid-column-' + this.id + '-' + this.module + '-' + fieldIndex;
		var savedOpens = window.sessionStorage.getItem(col);
		if(!savedOpens) {
			savedOpens = {};
		} else {
			savedOpens = JSON.parse(savedOpens);
		}
		savedOpens[id] = false;
		window.sessionStorage.setItem(col, JSON.stringify(savedOpens));
	},
	setRowHidden: function(id, state) {
		var that = this;
		var $row = $('#row-' + id);
		$row.data('hidden', state);
		var rows = $('.row-parent-' + id);
		$.each(rows, function(index, row) {
			var $row = $(row);
			var rowId = $row.attr('rel');
			that.setRowHidden(rowId, state);
		});
	},
	checkDisplayRows: function() {
		var rows = $('.row-item');
		$.each(rows, function(index, row) {
			var $row = $(row);
			var rowId = $row.attr('rel');
			var rowHidden = $row.data('hidden');
			if(rowHidden) {
				$row.hide();
			} else {
				$row.show();
			}
		});
	}
});
PzkCoreDbGrid.orderBys = [null, 'asc', 'desc'];