<?php

namespace App\Core\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use App\Shared\Views\Components\AdminLayout;
use App\Shared\Views\Components\TenantAdminLayout;

class ComponentsServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // Registrar vistas compartidas
        $this->loadViewsFrom(app_path('Shared/Views/Components'), 'shared');
        
        // Registrar vistas del Design System (disponible en todos los ambientes)
        $this->loadViewsFrom(app_path('Features/DesignSystem/Views'), 'design-system');
        $this->loadViewsFrom(app_path('Features/DesignSystem/Components'), 'design-system');
    }

    public function boot(): void
    {
        // Admin Components
        Blade::component('admin-layout', AdminLayout::class);
        Blade::component('tenant-admin-layout', TenantAdminLayout::class);
        
        // Registrar componentes individuales
        Blade::component('shared::admin.sidebar', 'admin-sidebar');
        Blade::component('shared::admin.navbar', 'admin-navbar');
        Blade::component('shared::admin.footer', 'admin-footer');
        Blade::component('shared::admin.tenant-sidebar', 'tenant-admin-sidebar');
        Blade::component('shared::admin.tenant-navbar', 'tenant-admin-navbar');
        
        // Registrar componentes del Design System (disponible en todos los ambientes)
        // (Removida restricción de ambiente local)
        {
            // Input components - Preline UI Based
            Blade::component('design-system::Inputs.InputPlaceholder', 'input-placeholder');
            Blade::component('design-system::Inputs.InputLabel', 'input-label');
            Blade::component('design-system::Inputs.InputBasic', 'input-basic');
            Blade::component('design-system::Inputs.InputHiddenLabel', 'input-hidden-label');
            Blade::component('design-system::Inputs.InputGray', 'input-gray');
            Blade::component('design-system::Inputs.InputFloatingLabel', 'input-floating-label');
            Blade::component('design-system::Inputs.InputSizes', 'input-sizes');
            Blade::component('design-system::Inputs.InputReadonly', 'input-readonly');
            Blade::component('design-system::Inputs.InputDisabled', 'input-disabled');
            Blade::component('design-system::Inputs.InputWithHelper', 'input-with-helper');
            Blade::component('design-system::Inputs.InputCornerHint', 'input-corner-hint');
            Blade::component('design-system::Inputs.InputValidation', 'input-validation');
            
            // Legacy input components (mantener compatibilidad)
            Blade::component('design-system::Inputs.InputWithLabel', 'input-with-label');
            Blade::component('design-system::Inputs.InputWithCornerHint', 'input-with-corner-hint');
            
            // Alert components - Preline UI Based
            Blade::component('design-system::Alerts.AlertSolid', 'alert-solid');
            Blade::component('design-system::Alerts.AlertSoft', 'alert-soft');
            Blade::component('design-system::Alerts.AlertBordered', 'alert-bordered');
            Blade::component('design-system::Alerts.AlertDismiss', 'alert-dismiss');
            Blade::component('design-system::Alerts.AlertDiscovery', 'alert-discovery');
            Blade::component('design-system::Alerts.AlertActions', 'alert-actions');
            Blade::component('design-system::Alerts.AlertWithList', 'alert-with-list');
            
            // Badge components - Preline UI Based
            Blade::component('design-system::Badges.BadgeSolid', 'badge-solid');
            Blade::component('design-system::Badges.BadgeSoft', 'badge-soft');
            Blade::component('design-system::Badges.BadgeMaxWidth', 'badge-max-width');
            Blade::component('design-system::Badges.BadgeIndicator', 'badge-indicator');
            Blade::component('design-system::Badges.BadgeIcon', 'badge-icon');
            Blade::component('design-system::Badges.BadgeRemovable', 'badge-removable');
            Blade::component('design-system::Badges.BadgeAvatar', 'badge-avatar');
            Blade::component('design-system::Badges.BadgePositioned', 'badge-positioned');
            Blade::component('design-system::Badges.BadgeButton', 'badge-button');
            
            // Button components - Preline UI Based
            Blade::component('design-system::Buttons.ButtonBase', 'button-base');
            Blade::component('design-system::Buttons.ButtonIcon', 'button-icon');
            Blade::component('design-system::Buttons.ButtonIconOnly', 'button-icon-only');
            Blade::component('design-system::Buttons.ButtonLoading', 'button-loading');
            Blade::component('design-system::Buttons.ButtonBlock', 'button-block');
            
            // Card components - Preline UI Based
            Blade::component('design-system::Cards.CardBase', 'card-base');
            Blade::component('design-system::Cards.CardScrollable', 'card-scrollable');
            Blade::component('design-system::Cards.CardEmptyState', 'card-empty-state');
            Blade::component('design-system::Cards.CardCentered', 'card-centered');
            Blade::component('design-system::Cards.CardPanelActions', 'card-panel-actions');
            Blade::component('design-system::Cards.CardHorizontal', 'card-horizontal');
            Blade::component('design-system::Cards.CardImage', 'card-image');
            Blade::component('design-system::Cards.CardWithAlert', 'card-with-alert');
            
            // Old input components (mantener compatibilidad)
            Blade::component('design-system::Inputs.TextInput', 'ds.text-input');
            Blade::component('design-system::Inputs.FloatingLabelInput', 'ds.floating-input');
            Blade::component('design-system::Inputs.InputWithIcon', 'input-with-icon');
            Blade::component('design-system::Inputs.Textarea', 'ds.textarea');
            
            // Datepicker components - Preline UI Based
            Blade::component('design-system::Datepickers.DatepickerSingle', 'datepicker-single');
            Blade::component('design-system::Datepickers.DatepickerRange', 'datepicker-range');
            Blade::component('design-system::Datepickers.DatepickerWithTime', 'datepicker-with-time');
            
            // List components - Preline UI Based
            Blade::component('design-system::Lists.ListBasic', 'list-basic');
            Blade::component('design-system::Lists.ListWithMarker', 'list-with-marker');
            Blade::component('design-system::Lists.ListSeparator', 'list-separator');
            Blade::component('design-system::Lists.ListChecked', 'list-checked');
            
            // List Group components - Preline UI Based
            Blade::component('design-system::ListGroups.ListGroupBasic', 'list-group-basic');
            Blade::component('design-system::ListGroups.ListGroupLinks', 'list-group-links');
            Blade::component('design-system::ListGroups.ListGroupButtons', 'list-group-buttons');
            Blade::component('design-system::ListGroups.ListGroupHorizontal', 'list-group-horizontal');
            Blade::component('design-system::ListGroups.ListGroupWithBadges', 'list-group-with-badges');
            Blade::component('design-system::ListGroups.ListGroupInvoice', 'list-group-invoice');
            Blade::component('design-system::ListGroups.ListGroupFiles', 'list-group-files');
            
            // Legend Indicator components - Preline UI Based
            Blade::component('design-system::LegendIndicators.LegendIndicator', 'legend-indicator');
            
            // Progress components - Preline UI Based
            Blade::component('design-system::Progress.ProgressBasic', 'progress-basic');
            Blade::component('design-system::Progress.ProgressWithLabel', 'progress-with-label');
            Blade::component('design-system::Progress.ProgressWithTitle', 'progress-with-title');
            Blade::component('design-system::Progress.ProgressMultiple', 'progress-multiple');
            Blade::component('design-system::Progress.ProgressVertical', 'progress-vertical');
            
            // File Upload components - Preline UI Based
            Blade::component('design-system::FileUpload.FileUploadProgress', 'file-upload-progress');
            Blade::component('design-system::FileUpload.FileUploadProgressMultiple', 'file-upload-progress-multiple');
            Blade::component('design-system::FileUploads.ImagePickerBasic', 'image-picker-basic');

            // Color picker components
            Blade::component('design-system::ColorPickers.ColorPickerBasic', 'color-picker-basic');
            
            // Ratings components - Preline UI Based
            Blade::component('design-system::Ratings.RatingBasic', 'rating-basic');
            Blade::component('design-system::Ratings.RatingButtons', 'rating-buttons');
            Blade::component('design-system::Ratings.RatingStatic', 'rating-static');
            Blade::component('design-system::Ratings.RatingEmoji', 'rating-emoji');
            Blade::component('design-system::Ratings.RatingThumbs', 'rating-thumbs');
            
            // Spinners components - Preline UI Based
            Blade::component('design-system::Spinners.SpinnerBasic', 'spinner-basic');
            Blade::component('design-system::Spinners.SpinnerCard', 'spinner-card');
            Blade::component('design-system::Spinners.SpinnerOverlay', 'spinner-overlay');
            
            // Toasts components - Preline UI Based
            Blade::component('design-system::Toasts.ToastBasic', 'toast-basic');
            Blade::component('design-system::Toasts.ToastCondensed', 'toast-condensed');
            Blade::component('design-system::Toasts.ToastSolid', 'toast-solid');
            Blade::component('design-system::Toasts.ToastSoft', 'toast-soft');
            Blade::component('design-system::Toasts.ToastLoading', 'toast-loading');
            Blade::component('design-system::Toasts.ToastWithActions', 'toast-with-actions');
            
            // Notification components
            Blade::component('design-system::Notifications.ToastNotification', 'toast-notification');
            
            // Timeline components - Preline UI Based
            Blade::component('design-system::Timeline.TimelineItem', 'timeline-item');
            Blade::component('design-system::Timeline.TimelineHeading', 'timeline-heading');
            Blade::component('design-system::Timeline.TimelineCollapsable', 'timeline-collapsable');
            
            // Navs components - Preline UI Based
            Blade::component('design-system::Navs.NavBasic', 'nav-basic');
            Blade::component('design-system::Navs.NavSegment', 'nav-segment');
            Blade::component('design-system::Navs.NavWithBadges', 'nav-with-badges');
            Blade::component('design-system::Navs.NavWithIcons', 'nav-with-icons');
            Blade::component('design-system::Navs.NavWithUnderline', 'nav-with-underline');
            
            // Tabs components - Preline UI Based
            Blade::component('design-system::Tabs.TabPills', 'tab-pills');
            Blade::component('design-system::Tabs.TabPillsGray', 'tab-pills-gray');
            Blade::component('design-system::Tabs.TabWithUnderline', 'tab-with-underline');
            Blade::component('design-system::Tabs.TabSegment', 'tab-segment');
            Blade::component('design-system::Tabs.TabCard', 'tab-card');
            Blade::component('design-system::Tabs.TabWithBadges', 'tab-with-badges');
            Blade::component('design-system::Tabs.TabWithIcons', 'tab-with-icons');
            Blade::component('design-system::Tabs.TabBarUnderline', 'tab-bar-underline');
            
            // Sidebar components - Preline UI Based
            Blade::component('design-system::Sidebar.SidebarContentPush', 'sidebar-content-push');
            
            // Breadcrumb components - Preline UI Based
            Blade::component('design-system::Breadcrumbs.BreadcrumbChevrons', 'breadcrumb-chevrons');
            Blade::component('design-system::Breadcrumbs.BreadcrumbSlashes', 'breadcrumb-slashes');
            Blade::component('design-system::Breadcrumbs.BreadcrumbWithIcons', 'breadcrumb-with-icons');
            
            // Pagination components - Preline UI Based
            Blade::component('design-system::Pagination.PaginationBorderedGroup', 'pagination-bordered-group');
            Blade::component('design-system::Pagination.PaginationCenter', 'pagination-center');
            Blade::component('design-system::Pagination.PaginationEnd', 'pagination-end');
            Blade::component('design-system::Pagination.PaginationWithOf', 'pagination-with-of');
            
            // Stepper components - Preline UI Based
            Blade::component('design-system::Stepper.StepperDynamicLinear', 'stepper-dynamic-linear');
            Blade::component('design-system::Stepper.StepperNonLinear', 'stepper-non-linear');
            Blade::component('design-system::Stepper.StepperSkipped', 'stepper-skipped');
            
            // Input Group components - Preline UI Based
            Blade::component('design-system::InputGroups.InputGroupCheckboxRadio', 'input-group-checkbox-radio');
            Blade::component('design-system::InputGroups.InputGroupLeadingButton', 'input-group-leading-button');
            Blade::component('design-system::InputGroups.InputGroupInlineAddon', 'input-group-inline-addon');
            Blade::component('design-system::InputGroups.InputGroupBasicAddon', 'input-group-basic-addon');
            Blade::component('design-system::InputGroups.InputGroupLeadingIcon', 'input-group-leading-icon');
            Blade::component('design-system::InputGroups.InputGroupSizes', 'input-group-sizes');
            
            // Textarea components - Preline UI Based
            Blade::component('design-system::Textareas.TextareaPlaceholder', 'textarea-placeholder');
            Blade::component('design-system::Textareas.TextareaWithLabel', 'textarea-with-label');
            Blade::component('design-system::Textareas.TextareaHiddenLabel', 'textarea-hidden-label');
            Blade::component('design-system::Textareas.TextareaGray', 'textarea-gray');
            Blade::component('design-system::Textareas.TextareaReadonly', 'textarea-readonly');
            Blade::component('design-system::Textareas.TextareaDisabled', 'textarea-disabled');
            Blade::component('design-system::Textareas.TextareaWithHelper', 'textarea-with-helper');
            Blade::component('design-system::Textareas.TextareaWithCornerHint', 'textarea-with-corner-hint');
            Blade::component('design-system::Textareas.TextareaAutoHeight', 'textarea-auto-height');
            Blade::component('design-system::Textareas.TextareaAutoHeightWithButton', 'textarea-auto-height-with-button');
            
            // File Input components - Preline UI Based
            Blade::component('design-system::FileInputs.FileInputButton', 'file-input-button');
            
            // Checkbox components - Preline UI Based
            Blade::component('design-system::Checkboxes.CheckboxBasic', 'checkbox-basic');
            Blade::component('design-system::Checkboxes.CheckboxGroup', 'checkbox-group');
            Blade::component('design-system::Checkboxes.CheckboxWithDescription', 'checkbox-with-description');
            Blade::component('design-system::Checkboxes.CheckboxInForm', 'checkbox-in-form');
            Blade::component('design-system::Checkboxes.CheckboxValidation', 'checkbox-validation');
            
            // Radio components - Preline UI Based
            Blade::component('design-system::Radios.RadioBasic', 'radio-basic');
            Blade::component('design-system::Radios.RadioGroup', 'radio-group');
            Blade::component('design-system::Radios.RadioWithDescription', 'radio-with-description');
            Blade::component('design-system::Radios.RadioInForm', 'radio-in-form');
            Blade::component('design-system::Radios.RadioValidation', 'radio-validation');
            
            // Switch/Toggle components - Preline UI Based
            Blade::component('design-system::Switches.SwitchBasic', 'switch-basic');
            Blade::component('design-system::Switches.SwitchWithDescription', 'switch-with-description');
            Blade::component('design-system::Switches.SwitchSizes', 'switch-sizes');
            Blade::component('design-system::Switches.SwitchSoft', 'switch-soft');
            Blade::component('design-system::Switches.SwitchValidation', 'switch-validation');
            
            // Select components - Preline UI Based
            Blade::component('design-system::Selects.SelectBasic', 'select-basic');
            Blade::component('design-system::Selects.SelectGray', 'select-gray');
            Blade::component('design-system::Selects.SelectSizes', 'select-sizes');
            Blade::component('design-system::Selects.SelectWithLabel', 'select-with-label');
            Blade::component('design-system::Selects.SelectValidation', 'select-validation');
            
            // Time Picker components - Preline UI Based
            Blade::component('design-system::TimePickers.TimePickerCustom', 'time-picker-custom');
            
            // Searchbox components - Preline UI Based
            Blade::component('design-system::Searchboxes.SearchboxDropdown', 'searchbox-dropdown');
            
            // Input Number components - Preline UI Based
            Blade::component('design-system::InputNumbers.InputNumberBasic', 'input-number-basic');
            Blade::component('design-system::InputNumbers.InputNumberWithLabel', 'input-number-with-label');
            Blade::component('design-system::InputNumbers.InputNumberMini', 'input-number-mini');
            Blade::component('design-system::InputNumbers.InputNumberPricing', 'input-number-pricing');
            Blade::component('design-system::InputNumbers.InputNumberValidation', 'input-number-validation');
            
            // Toggle Password components - Preline UI Based
            Blade::component('design-system::TogglePasswords.TogglePasswordBasic', 'toggle-password-basic');
            Blade::component('design-system::TogglePasswords.TogglePasswordMulti', 'toggle-password-multi');
            Blade::component('design-system::TogglePasswords.TogglePasswordInput', 'toggle-password-input');
            
            // Copy Markup components - Preline UI Based
            Blade::component('design-system::CopyMarkups.CopyMarkupBasic', 'copy-markup-basic');
            Blade::component('design-system::CopyMarkups.CopyMarkupPredefined', 'copy-markup-predefined');
            
            // PIN Input components - Preline UI Based
            Blade::component('design-system::PinInputs.PinInputBasic', 'pin-input-basic');
            Blade::component('design-system::PinInputs.PinInputGray', 'pin-input-gray');
            Blade::component('design-system::PinInputs.PinInputNumbersOnly', 'pin-input-numbers-only');
            Blade::component('design-system::PinInputs.PinInputModal', 'pin-input-modal');
            
            // Dropdown components - Preline UI Based
            Blade::component('design-system::Dropdowns.DropdownDefault', 'dropdown-default');
            Blade::component('design-system::Dropdowns.DropdownWithIcons', 'dropdown-with-icons');
            Blade::component('design-system::Dropdowns.DropdownWithTitle', 'dropdown-with-title');
            Blade::component('design-system::Dropdowns.DropdownWithHeader', 'dropdown-with-header');
            Blade::component('design-system::Dropdowns.DropdownCustomIconTrigger', 'dropdown-custom-icon-trigger');
            
            // Modal components - Preline UI Based
            Blade::component('design-system::Modals.ModalBasic', 'modal-basic');
            Blade::component('design-system::Modals.ModalScale', 'modal-scale');
            Blade::component('design-system::Modals.ModalSlideDown', 'modal-slide-down');
            Blade::component('design-system::Modals.ModalStaticBackdrop', 'modal-static-backdrop');
            
            // Popover components - Preline UI Based
            Blade::component('design-system::Popovers.PopoverLeft', 'popover-left');
            Blade::component('design-system::Popovers.PopoverTop', 'popover-top');
            Blade::component('design-system::Popovers.PopoverBottom', 'popover-bottom');
            Blade::component('design-system::Popovers.PopoverRight', 'popover-right');
            
            // Tooltip components - Preline UI Based
            Blade::component('design-system::Tooltips.TooltipTop', 'tooltip-top');
            Blade::component('design-system::Tooltips.TooltipRight', 'tooltip-right');
            Blade::component('design-system::Tooltips.TooltipBottom', 'tooltip-bottom');
            Blade::component('design-system::Tooltips.TooltipLeft', 'tooltip-left');
            
            // Table components - Preline UI Based
            Blade::component('design-system::Tables.TableHoverable', 'table-hoverable');
            Blade::component('design-system::Tables.TableGrayHeader', 'table-gray-header');
            Blade::component('design-system::Tables.TableWithPagination', 'table-with-pagination');
            
            // Chart components - Preline UI Based (requieren ApexCharts)
            Blade::component('design-system::Charts.ChartSingleArea', 'chart-single-area');
            Blade::component('design-system::Charts.ChartMultipleArea', 'chart-multiple-area');
            Blade::component('design-system::Charts.ChartSingleBar', 'chart-single-bar');
            Blade::component('design-system::Charts.ChartPie', 'chart-pie');
            
            // Dashboard components
            Blade::component('design-system::Dashboard.StatCard', 'stat-card');
            Blade::component('design-system::Dashboard.QuickActionButton', 'quick-action-button');
            Blade::component('design-system::Dashboard.OrdersTableWidget', 'orders-table-widget');
            Blade::component('design-system::Dashboard.AnnouncementCarousel', 'announcement-carousel');
            Blade::component('design-system::Dashboard.ChartWidget', 'chart-widget');
            Blade::component('design-system::Dashboard.PendingRequestsWidget', 'pending-requests-widget');
            Blade::component('design-system::Dashboard.LatestStoresTableWidget', 'latest-stores-table-widget');
            
            // Orders components
            Blade::component('design-system::Orders.OrdersStatsWidget', 'orders-stats-widget');
            Blade::component('design-system::Orders.OrdersFiltersWidget', 'orders-filters-widget');
            Blade::component('design-system::Orders.OrdersTable', 'orders-table');
            Blade::component('design-system::Orders.OrderReceiptPOS', 'order-receipt-pos');
            
            // Categories components
            Blade::component('design-system::Categories.CategoriesTable', 'categories-table');
            
            // Variables components
            Blade::component('design-system::Variables.VariablesTable', 'variables-table');
            
            // Modal components
            Blade::component('design-system::Modals.ModalConfirm', 'modal-confirm');
            Blade::component('design-system::Modals.ModalMasterKey', 'modal-master-key');
            
            // Clipboard components - Preline UI Based
            Blade::component('design-system::Clipboards.ClipboardBasic', 'clipboard-basic');
            Blade::component('design-system::Clipboards.ClipboardTooltip', 'clipboard-tooltip');
            
            // File Upload components - Preline UI Based (requieren Dropzone.js)
            Blade::component('design-system::FileUploads.FileUploadBasic', 'file-upload-basic');
            Blade::component('design-system::FileUploads.FileUploadError', 'file-upload-error');
            Blade::component('design-system::FileUploads.FileUploadGallery', 'file-upload-gallery');
            Blade::component('design-system::FileUploads.FileUploadSingleImage', 'file-upload-single-image');
            Blade::component('design-system::FileUploads.FileUploadWithValidation', 'file-upload-with-validation');
            
            // Empty State components
            Blade::component('design-system::EmptyStates.EmptyState', 'empty-state');
            
            // Icon Selector components
            Blade::component('design-system::IconSelectors.IconSelectorGrid', 'icon-selector-grid');
        }
    }
}