/*
 * Toastr
 * Copyright 2012-2015
 * Authors: John Papa, Hans Fjällemark, and Tim Ferrell.
 * All Rights Reserved.
 * Use, reproduction, distribution, and modification of this code is subject to the terms and
 * conditions of the MIT license, available at http://www.opensource.org/licenses/mit-license.php
 *
 * ARIA Support: Greta Krafsig
 *
 * Project: https://github.com/CodeSeven/toastr
 */
/* global define */
(function (define) {
  define(["jquery"], function ($) {
    return (function () {
      var $container;
      var listener;
      var toastId = 0;
      var toastType = {
        error: "error",
        info: "info",
        success: "success",
        warning: "warning",
        notification: "notification",
      };

      var toastr = {
        clear: clear,
        remove: remove,
        error: error,
        getContainer: getContainer,
        info: info,
        options: {},
        subscribe: subscribe,
        success: success,
        version: "2.1.4",
        warning: warning,
        notification: notification,
      };

      var previousToast;

      return toastr;

      ////////////////

      function error(message, title, optionsOverride) {
        return notify({
          type: toastType.error,
          iconClass: getOptions().iconClasses.error,
          titleClass: getOptions().titleClasses.error,
          message: message,
          optionsOverride: optionsOverride,
          title: title,
        });
      }

      function getContainer(options, create) {
        if (!options) {
          options = getOptions();
        }
        $container = $("#" + options.containerId);
        if ($container.length) {
          return $container;
        }
        if (create) {
          $container = createContainer(options);
        }
        return $container;
      }

      function info(message, title, optionsOverride) {
        return notify({
          type: toastType.info,
          titleClass: getOptions().titleClasses.info,
          iconClass: getOptions().iconClasses.info,
          message: message,
          optionsOverride: optionsOverride,
          title: title,
        });
      }

      function subscribe(callback) {
        listener = callback;
      }

      function success(message, title, optionsOverride) {
        return notify({
          type: toastType.success,
          titleClass: getOptions().titleClasses.success,
          iconClass: getOptions().iconClasses.success,
          message: message,
          optionsOverride: optionsOverride,
          title: title,
        });
      }

      function warning(message, title, optionsOverride) {
        return notify({
          type: toastType.warning,
          titleClass: getOptions().titleClasses.warning,
          iconClass: getOptions().iconClasses.warning,
          message: message,
          optionsOverride: optionsOverride,
          title: title,
        });
      }
      function notification(message, title, optionsOverride) {
        return notify({
          type: toastType.notification,
          titleClass: getOptions().titleClasses.notification,
          iconClass: getOptions().iconClasses.notification,
          message: message,
          optionsOverride: optionsOverride,
          title: title,
        });
      }

      function clear($toastElement, clearOptions) {
        var options = getOptions();
        if (!$container) {
          getContainer(options);
        }
        if (!clearToast($toastElement, options, clearOptions)) {
          clearContainer(options);
        }
      }

      function remove($toastElement) {
        var options = getOptions();
        if (!$container) {
          getContainer(options);
        }
        if ($toastElement && $(":focus", $toastElement).length === 0) {
          removeToast($toastElement);
          return;
        }
        if ($container.children().length) {
          $container.remove();
        }
      }

      // internal functions

      function clearContainer(options) {
        var toastsToClear = $container.children();
        for (var i = toastsToClear.length - 1; i >= 0; i--) {
          clearToast($(toastsToClear[i]), options);
        }
      }

      function clearToast($toastElement, options, clearOptions) {
        var force =
          clearOptions && clearOptions.force ? clearOptions.force : false;
        if (
          $toastElement &&
          (force || $(":focus", $toastElement).length === 0)
        ) {
          $toastElement[options.hideMethod]({
            duration: options.hideDuration,
            easing: options.hideEasing,
            complete: function () {
              removeToast($toastElement);
            },
          });
          return true;
        }
        return false;
      }

      function createContainer(options) {
        $container = $("<div/>")
          .attr("id", options.containerId)
          .attr("aria-live", "polite")
          .attr("aria-atomic", "true")
          .attr("style", "position: fixed; bottom: 0; right: 0; z-index:100;")
          .addClass(options.positionClass);

        $container.appendTo($(options.target));
        $container.wrap('<div class="position-relative "></div>');
        return $container;
      }

      function getDefaults() {
        return {
          tapToDismiss: true,
          toastClass: "toast fade show swal2-toast-shown",
          containerId: "toast-container212",
          debug: false,

          showMethod: "slideDown", //fadeIn, slideDown, and show are built into jQuery
          showDuration: 300,
          showEasing: "linear", //swing and linear are built into jQuery
          onShown: undefined,
          hideMethod: "slideUp",
          hideDuration: 300,
          hideEasing: "linear",
          onHidden: undefined, //aria-live="polite" aria-atomic="true"
          closeMethod: false,
          closeDuration: false,
          closeEasing: false,
          closeOnHover: true,

          extendedTimeOut: 10000,
          iconClasses: {
            error: "bg-danger",
            info: "bg-info",
            success: "bg-primary",
            warning: "bg-warning",
            notification: "bg-notification",
          },
          titleClasses: {
            error: "bg-light",
            info: "bg-light",
            success: "bg-light",
            warning: "bg-light",
            notification: "bg-notification-op",
          },
          iconClass: "toast-info",
          // positionClass: "toast-top-right",
          positionClass: "position-fixed m-2",
          timeOut: 5000, // Set timeOut and extendedTimeOut to 0 to make it sticky
          titleClass: "toast-header",
          messageClass: "toast-body",
          escapeHtml: false,
          target: "body",
          closeHtml: '<button type="button">&times;</button>',
          closeClass: "toast-close-button",
          newestOnTop: true,
          preventDuplicates: false,
          progressBar: false,
          progressClass: "toast-progress",
          rtl: false,
        };
      }

      function publish(args) {
        if (!listener) {
          return;
        }
        listener(args);
      }

      function notify(map) {
        var options = getOptions();
        var iconClass = map.iconClass || options.iconClass;
        var titleClass = map.titleClass || options.titleClasses;

        if (typeof map.optionsOverride !== "undefined") {
          options = $.extend(options, map.optionsOverride);
          iconClass = map.optionsOverride.iconClass || iconClass;
        }

        if (shouldExit(options, map)) {
          return;
        }

        toastId++;

        $container = getContainer(options, true);

        var intervalId = null;
        var $toastElement = $("<div/>");
        var $titleElement = $("<div/>");
        var $messageElement = $("<div/>");
        var $progressElement = $("<div/>");
        var $closeElement = $(options.closeHtml);
        var progressBar = {
          intervalId: null,
          hideEta: null,
          maxHideTime: null,
        };
        var response = {
          toastId: toastId,
          state: "visible",
          startTime: new Date(),
          options: options,
          map: map,
        };

        personalizeToast();

        displayToast();

        handleEvents();

        publish(response);

        if (options.debug && console) {
          console.log(response);
        }

        return $toastElement;

        function escapeHtml(source) {
          if (source == null) {
            source = "";
          }

          return source
            .replace(/&/g, "&amp;")
            .replace(/"/g, "&quot;")
            .replace(/'/g, "&#39;")
            .replace(/</g, "&lt;")
            .replace(/>/g, "&gt;");
        }

        function personalizeToast() {
          setIcon();
          setTitle(titleClass);
          setMessage();
          setCloseButton();
          setProgressBar();
          setRTL();
          setSequence();
          setAria();
        }

        function setAria() {
          var ariaValue = "";
          switch (map.iconClass) {
            case "toast-success":
            case "toast-info":
              ariaValue = "polite";
              break;
            default:
              ariaValue = "assertive";
          }
          $toastElement.attr("aria-live", ariaValue);
          $toastElement.attr("role", "alert");
        }

        function handleEvents() {
          if (options.closeOnHover) {
            $toastElement.hover(stickAround, delayedHideToast);
          }

          if (!options.onclick && options.tapToDismiss) {
            $toastElement.click(hideToast);
          }

          if (options.closeButton && $closeElement) {
            $closeElement.click(function (event) {
              if (event.stopPropagation) {
                event.stopPropagation();
              } else if (
                event.cancelBubble !== undefined &&
                event.cancelBubble !== true
              ) {
                event.cancelBubble = true;
              }

              if (options.onCloseClick) {
                options.onCloseClick(event);
              }

              hideToast(true);
            });
          }

          if (options.onclick) {
            $toastElement.click(function (event) {
              options.onclick(event);
              hideToast();
            });
          }
        }

        function displayToast() {
          $toastElement.hide();

          $toastElement[options.showMethod]({
            duration: options.showDuration,
            easing: options.showEasing,
            complete: options.onShown,
          });

          if (options.timeOut > 0) {
            intervalId = setTimeout(hideToast, options.timeOut);
            progressBar.maxHideTime = parseFloat(options.timeOut);
            progressBar.hideEta =
              new Date().getTime() + progressBar.maxHideTime;
            if (options.progressBar) {
              progressBar.intervalId = setInterval(updateProgress, 10);
            }
          }
        }

        function setIcon() {
          if (map.iconClass) {
            $toastElement
              .addClass(options.toastClass)
              .attr("role", "alert")
              .attr("aria-live", "assertive")
              .attr("aria-atomic", "true")
              .addClass(iconClass);
            //role="alert" aria-live="assertive" aria-atomic="true"
          }
        }

        function setSequence() {
          if (options.newestOnTop) {
            $container.prepend($toastElement);
          } else {
            $container.append($toastElement);
          }
        }

        function setTitle(titleclass = "") {
          //console.log(map.type);
          // console.log(options.iconClasses.map.type);
          if (map.title) {
            var suffix = map.title;
            if (options.escapeHtml) {
              suffix = escapeHtml(map.title);
            }
            if (titleclass.length > 0) {
              console.log(titleclass + "op");
            }
            $titleElement
              .append(
                '<svg class="bd-placeholder-img rounded mr-2" width="20" height="20" xmlns="http://www.w3.org/2000/svg" role="img" aria-label=" :  " preserveAspectRatio="xMidYMid slice" focusable="false"><title> </title><rect width="100%" height="100%" fill="#007aff"></rect><text x="50%" y="50%" fill="#dee2e6" dy=".3em"> </text></svg>'
              )
              .append(
                '<strong class="mr-auto text-capitalize">' +
                  suffix +
                  "</strong>"
              )
              .append(
                '<button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close"><span aria-hidden="true">&times;</span></button>'
              )
              .addClass(options.titleClass)
              .addClass(titleclass);
            $toastElement.append($titleElement);
            //<strong class="mr-auto"></strong>
          }
        }

        function setMessage() {
          if (map.message) {
            var suffix = map.message;
            if (options.escapeHtml) {
              suffix = escapeHtml(map.message);
            }
            $messageElement.append(suffix).addClass(options.messageClass);
            $toastElement.append($messageElement);
          }
        }

        function setCloseButton() {
          if (options.closeButton) {
            $closeElement.addClass(options.closeClass).attr("role", "button");
            $toastElement.prepend($closeElement);
          }
        }

        function setProgressBar() {
          if (options.progressBar) {
            $progressElement.addClass(options.progressClass);
            $toastElement.prepend($progressElement);
          }
        }

        function setRTL() {
          if (options.rtl) {
            $toastElement.addClass("rtl");
          }
        }

        function shouldExit(options, map) {
          if (options.preventDuplicates) {
            if (map.message === previousToast) {
              return true;
            } else {
              previousToast = map.message;
            }
          }
          return false;
        }

        function hideToast(override) {
          var method =
            override && options.closeMethod !== false
              ? options.closeMethod
              : options.hideMethod;
          var duration =
            override && options.closeDuration !== false
              ? options.closeDuration
              : options.hideDuration;
          var easing =
            override && options.closeEasing !== false
              ? options.closeEasing
              : options.hideEasing;
          if ($(":focus", $toastElement).length && !override) {
            return;
          }
          clearTimeout(progressBar.intervalId);
          return $toastElement[method]({
            duration: duration,
            easing: easing,
            complete: function () {
              removeToast($toastElement);
              clearTimeout(intervalId);
              if (options.onHidden && response.state !== "hidden") {
                options.onHidden();
              }
              response.state = "hidden";
              response.endTime = new Date();
              publish(response);
            },
          });
        }

        function delayedHideToast() {
          if (options.timeOut > 0 || options.extendedTimeOut > 0) {
            intervalId = setTimeout(hideToast, options.extendedTimeOut);
            progressBar.maxHideTime = parseFloat(options.extendedTimeOut);
            progressBar.hideEta =
              new Date().getTime() + progressBar.maxHideTime;
          }
        }

        function stickAround() {
          clearTimeout(intervalId);
          progressBar.hideEta = 0;
          $toastElement.stop(true, true)[options.showMethod]({
            duration: options.showDuration,
            easing: options.showEasing,
          });
        }

        function updateProgress() {
          var percentage =
            ((progressBar.hideEta - new Date().getTime()) /
              progressBar.maxHideTime) *
            100;
          $progressElement.width(percentage + "%");
        }
      }

      function getOptions() {
        return $.extend({}, getDefaults(), toastr.options);
      }

      function removeToast($toastElement) {
        if (!$container) {
          $container = getContainer();
        }
        if ($toastElement.is(":visible")) {
          return;
        }
        $toastElement.remove();
        $toastElement = null;
        if ($container.children().length === 0) {
          $container.remove();
          previousToast = undefined;
        }
      }
    })();
  });
})(
  typeof define === "function" && define.amd
    ? define
    : function (deps, factory) {
        if (typeof module !== "undefined" && module.exports) {
          //Node
          module.exports = factory(require("jquery"));
        } else {
          window.toastr = factory(window.jQuery);
        }
      }
);
