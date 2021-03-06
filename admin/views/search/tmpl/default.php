<?php
/**
 * @version 1.5 stable $Id: default.php 1803 2013-11-05 03:10:36Z ggppdk $
 * @package Joomla
 * @subpackage FLEXIcontent
 * @copyright (C) 2009 Emmanuel Danan - www.vistamedia.fr
 * @license GNU/GPL v2
 * 
 * FLEXIcontent is a derivative work of the excellent QuickFAQ component
 * @copyright (C) 2008 Christoph Lukes
 * see www.schlu.net for more information
 *
 * FLEXIcontent is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 */

defined('_JEXEC') or die('Restricted access');

$tip_class = FLEXI_J30GE ? ' hasTooltip' : ' hasTip';
$btn_class = FLEXI_J30GE ? 'btn' : 'fc_button fcsimple';

$start_text = '<span class="label">'.JText::_('FLEXI_COLUMNS', true).'</span>';
$end_text = '<div class="icon-arrow-up-2" title="'.JText::_('FLEXI_HIDE').'" style="cursor: pointer;" onclick="fc_toggle_box_via_btn(\\\'mainChooseColBox\\\', document.getElementById(\\\'fc_mainChooseColBox_btn\\\'), \\\'btn-primary\\\');"></div>';
flexicontent_html::jscode_to_showhide_table('mainChooseColBox', 'adminListTableFCsearch', $start_text, $end_text);

$edit_entry = JText::_('FLEXI_EDIT_TYPE', true);
?>

<script type="text/javascript">

// the function overloads joomla standard event
function submitform(pressbutton)
{
	form = document.adminForm;
	
	// Store the button task into the form
	if (pressbutton) {
		form.task.value=pressbutton;
	}

	// Execute onsubmit
	if (typeof form.onsubmit == "function") {
		form.onsubmit();
	}
	// Submit the form
	form.submit();
}

// delete active filter
function delFilter(name)
{
	//if(window.console) window.console.log('Clearing filter:'+name);
	var myForm = jQuery('#adminForm');
	var filter = jQuery('#'+name);
	if (filter.attr('type')=='checkbox')
		filter.checked = '';
	else
		filter.val('');
}

function delAllFilters() {
	delFilter('filter_fieldtype'); delFilter('filter_itemtype'); delFilter('filter_itemstate');
	delFilter('search'); delFilter('search_itemtitle'); delFilter('search_itemid');
}

</script>

<div class="flexicontent">

<form action="index.php?option=<?php echo $this->option; ?>&view=<?php echo $this->view; ?>" method="post" name="adminForm" id="adminForm">

<?php if (!empty( $this->sidebar)) : ?>
	<div id="j-sidebar-container" class="span2">
		<?php echo $this->sidebar; ?>
	</div>
	<div id="j-main-container" class="span10">
<?php else : ?>
	<div id="j-main-container">
<?php endif;?>


	<div id="fc-filters-header">
		<span class="fc-filter nowrap_box">
			<span class="filter-search btn-group">
				<input type="text" name="search" id="search" placeholder="<?php echo JText::_( 'FLEXI_SEARCH' ); ?>" value="<?php echo htmlspecialchars($this->lists['search'], ENT_QUOTES, 'UTF-8'); ?>" class="inputbox" />
			</span>
			<span class="btn-group hidden-phone">
				<button title="<?php echo JText::_('FLEXI_APPLY_FILTERS'); ?>" class="<?php echo $btn_class; ?>" onclick="this.form.submit();"><?php echo FLEXI_J30GE ? '<i class="icon-search"></i>' : JText::_('FLEXI_GO'); ?></button>
				<button title="<?php echo JText::_('FLEXI_RESET_FILTERS'); ?>" class="<?php echo $btn_class; ?>" onclick="delAllFilters();this.form.submit();"><?php echo FLEXI_J30GE ? '<i class="icon-remove"></i>' : JText::_('FLEXI_CLEAR'); ?></button>
			</span>
		</span>
		
		<?php $_class = FLEXI_J30GE ? ' btn' : ' fc_button fcsimple fcsmall'; ?>
		<div class="btn-group" style="margin: 2px 32px 6px -3px; display:inline-block;">
			<input type="button" id="fc_filters_box_btn" class="<?php echo $_class.($this->count_filters ? ' btn-primary' : ''); ?>" onclick="fc_toggle_box_via_btn('fc-filters-box', this, 'btn-primary');" value="<?php echo JText::_( 'FLEXI_FILTERS' ); ?>" />
			<input type="button" id="fc_mainChooseColBox_btn" class="<?php echo $_class; ?>" onclick="fc_toggle_box_via_btn('mainChooseColBox', this, 'btn-primary');" value="<?php echo JText::_( 'FLEXI_COLUMNS' ); ?>" />
		</div>
		
		<span class="fc-filter nowrap_box">
			<span class="limit nowrap_box" style="display: inline-block;">
				<label class="label">
					<?php echo JText::_(FLEXI_J16GE ? 'JGLOBAL_DISPLAY_NUM' : 'DISPLAY NUM'); ?>
				</label>
				<?php
				$pagination_footer = $this->pagination->getListFooter();
				if (strpos($pagination_footer, '"limit"') === false) echo $this->pagination->getLimitBox();
				?>
			</span>
			
			<span class="fc_item_total_data nowrap_box badge badge-info">
				<?php echo @$this->resultsCounter ? $this->resultsCounter : $this->pagination->getResultsCounter(); // custom Results Counter ?>
			</span>
			
			<?php if (($getPagesCounter = $this->pagination->getPagesCounter())): ?>
			<span class="fc_pages_counter nowrap_box fc-mssg-inline fc-info fc-nobgimage">
				<?php echo $getPagesCounter; ?>
			</span>
			<?php endif; ?>
			
		</span>
	</div>
	
	
	<div id="fc-filters-box" <?php if (!$this->count_filters) echo 'style="display:none;"'; ?> class="">
		<!--<span class="label"><?php echo JText::_( 'FLEXI_FILTERS' ); ?></span>-->
		
		<span class="fc-filter nowrap_box">
			<?php echo '<label class="label'.($this->f_active['search_itemtitle'] ? " highlight":"").'">'.JText::_('FLEXI_TITLE').'</label> '; ?>
			<input type="text" name="search_itemtitle" id="search_itemtitle" value="<?php echo $this->lists['search_itemtitle']; ?>" class="text_area" onchange="document.adminForm.submit();" size="30"/>
		</span>

		<span class="fc-filter nowrap_box">
			<?php echo '<label class="label'.($this->f_active['search_itemid'] ? " highlight":"").'">'.JText::_('FLEXI_ID').'</label> '; ?>
			<input type="text" name="search_itemid" id="search_itemid" value="<?php echo $this->lists['search_itemid']; ?>" class="text_area" onchange="document.adminForm.submit();" size="6" />
		</span>
			
		<span class="fc-filter nowrap_box">
			<?php echo $this->lists['filter_itemtype']; ?>
		</span>
			
		<span class="fc-filter nowrap_box">
			<?php echo $this->lists['filter_itemstate']; ?>
		</span>
		
		<span class="fc-filter nowrap_box">
			<?php echo $this->lists['filter_fieldtype']; ?>
		</span>
		
		<div class="icon-arrow-up-2" title="<?php echo JText::_('FLEXI_HIDE'); ?>" style="cursor: pointer;" onclick="fc_toggle_box_via_btn('fc-filters-box', document.getElementById('fc_filters_box_btn'), 'btn-primary');"></div>
	</div>
	
	<div id="mainChooseColBox" class="fc_mini_note_box well well-small" style="display:none;"></div>
	
	<div class="fcclear"></div>
	<?php echo '<span class="label">'.JText::_('FLEXI_LISTING_RECORDS').': </span>'.$this->lists['filter_indextype']; ?>
	<div class="fcclear"></div>
	
	<table id="adminListTableFCsearch" class="adminlist fcmanlist">
	<thead>
		<tr>
			<th><?php echo JText::_( 'FLEXI_NUM' ); ?></th>
			<th><input type="checkbox" name="toggle" value="" onclick="<?php echo FLEXI_J30GE ? 'Joomla.checkAll(this);' : 'checkAll('.count( $this->rows).');'; ?>" /></th>
			<th class="hideOnDemandClass title"><?php echo JHTML::_('grid.sort', JText::_('FLEXI_ITEMS'), 'a.title', $this->lists['order_Dir'], $this->lists['order'] ); ?></th>
			<th class="hideOnDemandClass"><?php echo JHTML::_('grid.sort', JText::_('FLEXI_FIELD_INDEX').' '.JText::_('FLEXI_FIELD_LABEL'), 'f.label', $this->lists['order_Dir'], $this->lists['order'] ); ?></th>
			<th class="hideOnDemandClass"><?php echo JHTML::_('grid.sort', JText::_('FLEXI_FIELD_INDEX').' '.JText::_('FLEXI_FIELD_NAME'), 'f.name', $this->lists['order_Dir'], $this->lists['order'] ); ?></th>
			<th class="hideOnDemandClass"><?php echo JHTML::_('grid.sort', JText::_('FLEXI_FIELD_TYPE'), 'f.field_type', $this->lists['order_Dir'], $this->lists['order'] ); ?></th>
			<th class="hideOnDemandClass"><?php echo JHTML::_('grid.sort', JText::_('FLEXI_INDEX_VALUE_COUNT'), 'ai.extraid', $this->lists['order_Dir'], $this->lists['order'] ); ?></th>
			<th class="hideOnDemandClass"><?php echo JHTML::_('grid.sort', JText::_('FLEXI_SEARCH_INDEX'), 'ai.search_index', $this->lists['order_Dir'], $this->lists['order'] ); ?></th>
			<th class="hideOnDemandClass"><?php echo JHTML::_('grid.sort', JText::_('FLEXI_INDEX_VALUE_ID'), 'ai.value_id', $this->lists['order_Dir'], $this->lists['order'] ); ?></th>
		</tr>
	</thead>
		
	<tfoot>
		<tr>
			<td colspan="9" nowrap="nowrap">
				<?php echo $pagination_footer; ?>
			</td>
		</tr>
	</tfoot>
	
	<tbody>
		
		<?php if (count($this->rows) == 0): ?>
		<tr class="row0">
			<td align="center" colspan="9">
				<?php
				if ($this->total == 0) {
					echo JText::_('FLEXI_NO_DATA');
					//echo JText::_('FINDER_INDEX_TIP');
				} else {
					echo JText::_('FINDER_INDEX_NO_CONTENT');
				}
				?>
			</td>
		</tr>
		<?php endif; ?>

		<?php
		$n = 0; $o = 0;
		foreach ($this->rows as $row): ?>
		<tr class="<?php echo 'row', $o; ?>">
			<td>
				<?php echo $this->pagination->getRowOffset( $n ); ?>
			</td>
			<td align="center">
				<?php echo JHTML::_('grid.id', $n, $row->field_id.'|'.$row->item_id); ?>
			</td>
			<td>
				<?php echo '<a target="_blank" href="index.php?option=com_flexicontent&amp;task=items.edit&amp;cid[]='.$row->id.'" title="'.$edit_entry.'">'.$this->escape($row->title).'</a>'; ?>
			</td>
			<td>
				<?php echo $this->escape($row->label); ?>
			</td>
			<td>
				<?php echo $this->escape($row->name); ?>
			</td>
			<td nowrap="nowrap" style="text-align: center" class="col_fieldtype">
				<?php echo $row->field_type; ?>
			</td>
			<td nowrap="nowrap" style="text-align: center;">
				<?php echo $row->extraid; ?>
			</td>
			<td style="text-align: left;" class="col_search_index">
				<?php
					if(iconv_strlen($row->search_index, "UTF-8")>400)
						echo iconv_substr($row->search_index, 0, 400, "UTF-8").'...';
					else
						echo $row->search_index;
				?>
			</td>
			<td nowrap="nowrap" style="text-align: center;">
				<?php echo $row->value_id; ?>
			</td>
			<?php /*<td nowrap="nowrap" style="text-align: center;">
				<?php //echo JHtml::date($row->indexdate, '%Y-%m-%d %H:%M:%S'); ?>
			</td>*/ ?>
		</tr>

		<?php $n++; $o = ++$o % 2; ?>
		<?php endforeach; ?>
	</tbody>
	</table>

	<input type="hidden" name="task" value="display" />
	<input type="hidden" name="boxchecked" value="0" />
	<input type="hidden" name="filter_order" value="<?php echo $this->lists['order']; ?>" />
	<input type="hidden" name="filter_order_Dir" value="<?php echo $this->lists['order_Dir']; ?>" />
	<input type="hidden" name="controller" value="search" />
	<?php echo JHTML::_('form.token'); ?>
	
	</div>
</form>
</div>