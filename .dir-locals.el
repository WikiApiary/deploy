;; This is here to enable emacs users to use tab-completion and other features provided by Red Hat's
;; ansible language server.  See https://emacs-lsp.github.io/lsp-mode/page/lsp-ansible/
;;
;; Users of VS Code can use the Red Hat's VSCode extension:
;; https://www.ansible.com/blog/deep-dive-on-ansible-vscode-extension
((yaml-mode . ((eval . (progn
                         (ansible)
                         (lsp)
                         (company-mode))
                     ))))
