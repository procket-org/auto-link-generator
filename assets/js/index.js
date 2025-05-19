// Initialize AOS animation
AOS.init({
    duration: 1000,
    once: true
});

// Multi-language configuration
const resources = {
    en: {
        translation: {
            hero: {
                title: "Auto Link Generator",
                description: "Intelligent automatic internal link generation, improving SEO and user experience",
                button: {
                    features: "View Features"
                }
            },
            features: {
                title: "Key Features",
                subtitle: "Powerful tools to enhance your website's SEO and user experience",
                automatic: {
                    title: "Automatic Link Generation",
                    description: "Automatically convert keywords to links based on predefined rules, improving content connectivity."
                },
                tags: {
                    title: "Tag Integration",
                    description: "Automatically generate links from article tags, enhancing content relationships."
                },
                management: {
                    title: "Advanced Management",
                    description: "A simple and elegant admin interface for easily managing all post links."
                }
            },
            requirements: {
                title: "System Requirements",
                subtitle: "Ensure your system meets these requirements for optimal performance",
                wordpress: "WordPress 5.0+",
                php: "PHP 7.0+",
                mysql: "MySQL 5.6+",
                browsers: "Modern Browsers"
            },
            guide: {
                title: "Usage Guide",
                subtitle: "Follow these simple steps to get started",
                installation: {
                    title: "Installation",
                    step1: "Download from WordPress plugin repository",
                    step2: "Upload to your plugins directory",
                    step3: "Activate through WordPress admin"
                },
                configuration: {
                    title: "Configuration",
                    step1: "Go to Settings > Auto Link in WordPress admin",
                    step2: "Configure global settings like case sensitivity and max links",
                    step3: "Add keywords and corresponding URLs"
                },
                usage: {
                    title: "Usage",
                    step1: "Post tags will be automatically converted into links",
                    step2: "View custom keywords in admin panel",
                    step3: "Adjust settings as needed"
                }
            },
            testimonials: {
                title: "Testimonials",
                subtitle: "Real feedback from users around the world",
                review1: "This is the best auto-linking plugin I've ever used. It saves so much time! Significant SEO improvements.",
                client1: "Sarah Johnson",
                position1: "Tech Blogger",
                review2: "Intuitive interface, powerful functionality, completely meets my needs. After one month of use, my site traffic increased by 20%.",
                client2: "David Chen",
                position2: "SEO Specialist",
                review3: "Customer support is responsive and professional. Every issue I encountered was promptly resolved.",
                client3: "Maria Garcia",
                position3: "Content Manager"
            },
            faq: {
                title: "FAQ",
                subtitle: "Answers to common questions",
                q1: "Why aren't some keywords automatically linked?",
                a1: "Please check whether the maximum number of links has been exceeded and whether the case sensitivity settings are met. In some cases, keywords inside HTML tags or within existing links will not be replaced.",
                q2: "How to disable linking in specific articles?",
                a2: "Simply add the excluded posts in the Auto Link settings in the admin panel."
            },
            changelog: {
                title: "Changelog",
                subtitle: "Continuous improvements for better experience",
                v2: {
                    feature1: "Added creation time display for better keyword management",
                    feature2: "Optimized UI/UX for better operational experience",
                    feature3: "Added multi-language support (8 languages) to meet international user needs"
                },
                v1: {
                    feature1: "Initial release with basic functionality",
                    feature2: "Basic auto-linking with keyword matching",
                    feature3: "Admin interface for keyword and link management"
                }
            },
            support: {
                title: "Support",
                subtitle: "We're here to help",
                documentation: {
                    title: "Documentation",
                    description: "Detailed guides and tutorials to help you make the most of the plugin",
                    button: "View Docs"
                },
                forum: {
                    title: "Github",
                    description: "Feel free to ask me questions and tell me what you need right here",
                    button: "Visit Github"
                },
                contact: {
                    title: "Contact",
                    description: "Professional support team ready to answer your questions",
                    button: "Send Email"
                }
            },
            footer: {
                about: {
                    title: "About Auto Link Generator",
                    description: "A powerful WordPress plugin for automatic internal linking, dedicated to improving website SEO performance and user experience"
                },
                links: {
                    title: "Quick Links",
                    features: "Features",
                    docs: "Documentation",
                    support: "Support"
                },
                social: {
                    title: "Follow Us"
                },
                copyright: "© 2024 Auto Link Generator. All rights reserved.",
                license: "Released under GPLv2 license. Full text in LICENSE file."
            }
        }
    },
    zh_CN: {
        translation: {
            hero: {
                title: "自动链接生成器",
                description: "智能自动生成内部链接，提升SEO效果，优化用户体验",
                button: {
                    features: "了解功能"
                }
            },
            features: {
                title: "核心功能",
                subtitle: "强大的工具，提升您网站的SEO和用户体验",
                automatic: {
                    title: "自动链接生成",
                    description: "基于预定义规则自动将关键词转换为链接，提升内容互联性"
                },
                tags: {
                    title: "标签集成",
                    description: "从文章标签自动生成链接，增强内容关联性"
                },
                management: {
                    title: "高级管理",
                    description: "简洁优雅的管理界面，轻松管理所有文章链接"
                }
            },
            requirements: {
                title: "系统要求",
                subtitle: "确保您的系统满足以下要求以获得最佳体验",
                wordpress: "WordPress 5.0 或更高版本",
                php: "PHP 7.0 或更高版本",
                mysql: "MySQL 5.6 或更高版本",
                browsers: "现代浏览器"
            },
            guide: {
                title: "使用指南",
                subtitle: "按照以下简单步骤，开启自动链接之旅",
                installation: {
                    title: "安装",
                    step1: "从WordPress插件库下载",
                    step2: "上传到插件目录",
                    step3: "通过WordPress后台激活"
                },
                configuration: {
                    title: "配置",
                    step1: "进入WordPress管理界面的设置 > 自动链接",
                    step2: "配置全局设置如大小写敏感度和最大链接数",
                    step3: "添加关键词和对应URL"
                },
                usage: {
                    title: "使用",
                    step1: "文章标签会自动转换为链接",
                    step2: "在管理界面查看自定义关键词",
                    step3: "根据需要调整设置"
                }
            },
            testimonials: {
                title: "用户评价",
                subtitle: "来自全球用户的真实反馈",
                review1: "这是我用过的最好的自动链接插件，节省了大量时间！SEO效果显著提升。",
                client1: "莎拉·约翰逊",
                position1: "科技博主",
                review2: "界面直观，功能强大，完全满足了我的需求。使用一个月后，网站流量提升了20%。",
                client2: "陈大卫",
                position2: "SEO专家",
                review3: "客户支持响应迅速，解决问题非常专业。遇到的每个问题都得到了及时解决。",
                client3: "玛丽亚·加西亚",
                position3: "内容管理员"
            },
            faq: {
                title: "常见问题",
                subtitle: "解答您最关心的问题",
                q1: "为什么某些关键词没有自动链接？",
                a1: "请检查是否超过了最大链接数限制，以及是否符合大小写设置。某些情况下，如果关键词出现在HTML标签内或已有链接中，也不会被替换。",
                q2: "如何在特定文章中禁用自动链接？",
                a2: "只需在自动链接设置中的管理面板中添加排除的文章即可。"
            },
            changelog: {
                title: "更新日志",
                subtitle: "持续改进，为您带来更好的体验",
                v2: {
                    feature1: "添加创建时间显示功能，更好地管理关键词",
                    feature2: "优化用户界面，提升操作体验",
                    feature3: "添加多语言支持（8种语言），满足国际用户需求"
                },
                v1: {
                    feature1: "首次发布，提供基础功能",
                    feature2: "基础自动链接功能，支持关键词匹配",
                    feature3: "后台管理界面，便于管理关键词和链接"
                }
            },
            support: {
                title: "技术支持",
                subtitle: "我们随时为您提供帮助",
                documentation: {
                    title: "文档",
                    description: "详细的使用文档和教程，帮助您充分利用插件功能",
                    button: "查看文档"
                },
                forum: {
                    title: "Github",
                    description: "欢迎在这里随时向我提问并告诉我你的需求～",
                    button: "访问Github"
                },
                contact: {
                    title: "联系我们",
                    description: "专业的技术支持团队，随时解答您的问题",
                    button: "发送邮件"
                }
            },
            footer: {
                about: {
                    title: "关于自动链接生成器",
                    description: "一个用于自动内部链接的强大WordPress插件，致力于提升网站SEO性能和用户体验"
                },
                links: {
                    title: "快速链接",
                    features: "功能",
                    docs: "文档",
                    support: "支持"
                },
                social: {
                    title: "关注我们"
                },
                copyright: "© 2024 自动链接生成器。保留所有权利。",
                license: "本插件基于GPLv2许可证发布。完整许可证文本可在LICENSE文件中找到。"
            }
        }
    },
    zh_TW: {
        translation: {
            hero: {
                title: "自動鏈接生成器",
                description: "智能自動生成內部鏈接，提升SEO效果，優化用戶體驗",
                button: {
                    features: "了解功能"
                }
            },
            features: {
                title: "核心功能",
                subtitle: "強大的工具，提升您網站的SEO和用戶體驗",
                automatic: {
                    title: "自動鏈接生成",
                    description: "基於預定義規則自動將關鍵詞轉換為鏈接，提升內容互聯性"
                },
                tags: {
                    title: "標籤統合",
                    description: "從文章標籤自動生成鏈接，增強內容關聯性"
                },
                management: {
                    title: "高級管理",
                    description: "簡潔優雅的管理界面，輕鬆管理所有文章鏈接"
                }
            },
            requirements: {
                title: "系統要求",
                subtitle: "確保您的系統滿足以下要求以獲得最佳體驗",
                wordpress: "WordPress 5.0 或更高版本",
                php: "PHP 7.0 或更高版本",
                mysql: "MySQL 5.6 或更高版本",
                browsers: "現代瀏覽器"
            },
            guide: {
                title: "使用指南",
                subtitle: "按照以下簡單步驟，開啟自動鏈接之旅",
                installation: {
                    title: "安裝",
                    step1: "從WordPress插件庫下載",
                    step2: "上傳到插件目錄",
                    step3: "通過WordPress後台激活"
                },
                configuration: {
                    title: "配置",
                    step1: "進入WordPress管理界面的設定 > 自動鏈接",
                    step2: "配置全局設定如大小寫敏感度和最大鏈接數",
                    step3: "添加關鍵詞和對應URL"
                },
                usage: {
                    title: "使用",
                    step1: "文章標籤會自動轉換為鏈接",
                    step2: "在管理界面查看自定義關鍵詞",
                    step3: "根據需要調整設置"
                }
            },
            testimonials: {
                title: "用戶評價",
                subtitle: "來自全球用戶的真實反饋",
                review1: "這是我用過的最好的自動鏈接插件，節省了大量時間！SEO效果顯著提升。",
                client1: "莎拉·約翰遜",
                position1: "科技博主",
                review2: "界面直觀，功能強大，完全滿足了我的需求。使用一個月後，網站流量提升了20%。",
                client2: "陳大衛",
                position2: "SEO專家",
                review3: "客戶支持響應迅速，解決問題非常專業。遇到的每個問題都得到了及時解決。",
                client3: "瑪麗亞·加西亞",
                position3: "內容管理員"
            },
            faq: {
                title: "常見問題",
                subtitle: "解答您最關心的問題",
                q1: "為什麼某些關鍵詞沒有自動鏈接？",
                a1: "請檢查是否超過了最大鏈接數限制，以及是否符合大小寫設置。某些情況下，如果關鍵詞出現在HTML標籤內或已有鏈接中，也不會被替換。",
                q2: "如何在特定文章中禁用自動鏈接？",
                a2: "只需在自動鏈接設置中的管理面板中添加排除的文章即可。"
            },
            changelog: {
                title: "更新日誌",
                subtitle: "持續改進，為您帶來更好的體驗",
                v2: {
                    feature1: "添加創建時間顯示功能，更好地管理關鍵詞",
                    feature2: "優化用戶界面，提升操作體驗",
                    feature3: "添加多語言支持（8種語言），滿足國際用戶需求"
                },
                v1: {
                    feature1: "首次發布，提供基礎功能",
                    feature2: "基礎自動鏈接功能，支持關鍵詞匹配",
                    feature3: "後台管理界面，便於管理關鍵詞和鏈接"
                }
            },
            support: {
                title: "技術支持",
                subtitle: "我們隨時為您提供幫助",
                documentation: {
                    title: "文檔",
                    description: "詳細的使用文檔和教程，幫助您充分利用插件功能",
                    button: "查看文檔"
                },
                forum: {
                    title: "Github",
                    description: "歡迎在這裡隨時向我提問並告訴我你的需求～",
                    button: "訪問Github"
                },
                contact: {
                    title: "聯繫我們",
                    description: "專業的技術支持團隊，隨時解答您的問題",
                    button: "發送郵件"
                }
            },
            footer: {
                about: {
                    title: "關於自動鏈接生成器",
                    description: "一個用於自動內部鏈接的強大WordPress插件，致力於提升網站SEO性能和用戶體驗"
                },
                links: {
                    title: "快速鏈接",
                    features: "機能",
                    docs: "文檔",
                    support: "支持"
                },
                social: {
                    title: "關注我們"
                },
                copyright: "© 2024 自動鏈接生成器。全權利所有。",
                license: "本插件基於GPLv2許可證發布。完整許可證文本可在LICENSE文件中找到。"
            }
        }
    },
    ja: {
        translation: {
            hero: {
                title: "自動リンク生成ツール",
                description: "インテリジェントな内部リンク自動生成で、SEO ペフォーマンス とユーザー体験を向上",
                button: {
                    features: "機能を見る"
                }
            },
            features: {
                title: "主な機能",
                subtitle: "ウェブサイトのSEOとユーザー体験を向上させる強力なツール",
                automatic: {
                    title: "自動リンク生成",
                    description: "事前定義されたルールに基づいてキーワードを自動的にリンクに変換し、コンテンツの接続性を向上"
                },
                tags: {
                    title: "タグ統合",
                    description: "記事のタグから自動的にリンクを生成し、コンテンツの関連性を強化"
                },
                management: {
                    title: "高度な管理",
                    description: "シンプルでエレガントな管理インターフェースで、すべての投稿リンクを簡単に管理"
                }
            },
            requirements: {
                title: "システム要件",
                subtitle: "最適なパフォーマンスを得るために、以下の要件を満たしていることをご確認ください",
                wordpress: "WordPress 5.0以上",
                php: "PHP 7.0以上",
                mysql: "MySQL 5.6以上",
                browsers: "モダンブラウザ"
            },
            guide: {
                title: "使用ガイド",
                subtitle: "簡単な手順で始めましょう",
                installation: {
                    title: "インストール",
                    step1: "WordPressプラグインリポジトリからダウンロード",
                    step2: "プラグインディレクトリにアップロード",
                    step3: "WordPress管理画面で有効化"
                },
                configuration: {
                    title: "設定",
                    step1: "WordPress管理画面の設定 > 自動リンクに移動",
                    step2: "大文字小文字の区別や最大リンク数などのグローバル設定を構成",
                    step3: "キーワードと対応するURLを追加"
                },
                usage: {
                    title: "使用方法",
                    step1: "記事のタグが自動的にリンクに変換されます",
                    step2: "管理パネルでカスタムキーワードを確認",
                    step3: "必要に応じて設定を調整"
                }
            },
            testimonials: {
                title: "お客様の声",
                subtitle: "世界中のユーザーからの実際のフィードバック",
                review1: "これまで使った中で最高の自動リンク生成プラグインです。時間の節約になり、SEOも大幅に改善されました！",
                client1: "サラ・ジョンソン",
                position1: "テックブロガー",
                review2: "直感的なインターフェース、強力な機能性で、私のニーズを完全に満たしています。使用開始から1ヶ月で、サイトのトラフィックが20%増加しました。",
                client2: "デビッド・チェン",
                position2: "SEOスペシャリスト",
                review3: "カスタマーサポートが迅速で専門的です。遭遇した問題はすべて迅速に解決されました。",
                client3: "マリア・ガルシア",
                position3: "コンテンツマネージャー"
            },
            faq: {
                title: "よくある質問",
                subtitle: "一般的な質問への回答",
                q1: "なぜ一部のキーワードが自動的にリンクされないのですか？",
                a1: "最大リンク数を超えていないか、大文字小文字の設定が満たされているかを確認してください。場合によっては、HTMLタグ内や既存のリンク内のキーワードは置き換えられません。",
                q2: "特定の記事でリンク生成を無効にするにはどうすればよいですか？",
                a2: "管理パネルの自動リンク設定で、除外する投稿を追加するだけです。"
            },
            changelog: {
                title: "変更履歴",
                subtitle: "より良い体験のための継続的な改善",
                v2: {
                    feature1: "キーワード管理を向上させるための作成時間表示を追加",
                    feature2: "操作性向上のためのUI/UX最適化",
                    feature3: "国際的なユーザーのニーズに応えるための多言語サポート（8言語）を追加"
                },
                v1: {
                    feature1: "基本機能を備えた初回リリース",
                    feature2: "キーワードマッチングによる基本的な自動リンク機能",
                    feature3: "キーワードとリンク管理のための管理インターフェース"
                }
            },
            support: {
                title: "サポート",
                subtitle: "私たちがお手伝いします",
                documentation: {
                    title: "ドキュメント",
                    description: "プラグインを最大限に活用するための詳細なガイドとチュートリアル",
                    button: "ドキュメントを見る"
                },
                forum: {
                    title: "Github",
                    description: "こちらでいつでも質問やご要望をお気軽にお伝えください",
                    button: "Githubにアクセス"
                },
                contact: {
                    title: "お問い合わせ",
                    description: "プロフェッショナルなサポートチームがご質問にお答えします",
                    button: "Eメイル 送信"
                }
            },
            footer: {
                about: {
                    title: "自動リンク生成ツールについて",
                    description: "自動内部リンク生成のための強力なWordPressプラグインで、ウェブサイトのSEOパフォーマンスとユーザー体験の向上に貢献します"
                },
                links: {
                    title: "クイックリンク",
                    features: "機能",
                    docs: "ドキュメント",
                    support: "サポート"
                },
                social: {
                    title: "フォローする"
                },
                copyright: "© 2024 自動リンク生成ツール。全著作権所有。",
                license: "GPLv2ライセンスの下でリリースされています。完全なテキストはLICENSEファイルにあります。"
            }
        }
    },
    ko: {
        translation: {
            hero: {
                title: "자동 링크 생성기",
                description: "지능형 자동 내부 링크 생성으로 SEO 및 사용자 경험 향상",
                button: {
                    features: "기능 보기"
                }
            },
            features: {
                title: "주요 기능",
                subtitle: "웹사이트의 SEO와 사용자 경험을 향상시키는 강력한 도구",
                automatic: {
                    title: "자동 링크 생성",
                    description: "사전 정의된 규칙에 따라 키워드를 자동으로 링크로 변환하여 콘텐츠 연결성 향상"
                },
                tags: {
                    title: "태그 통합",
                    description: "글의 태그에서 자동으로 링크를 생성하여 콘텐츠 관련성 강화"
                },
                management: {
                    title: "고급 관리",
                    description: "간결하고 우아한 관리 인터페이스로 모든 게시물 링크를 쉽게 관리"
                }
            },
            requirements: {
                title: "시스템 요구 사항",
                subtitle: "최적의 성능을 위해 다음 요구 사항을 확인하세요",
                wordpress: "워드프레스 5.0 이상",
                php: "PHP 7.0 이상",
                mysql: "MySQL 5.6 이상",
                browsers: "현대적인 브라우저"
            },
            guide: {
                title: "사용 가이드",
                subtitle: "다음 간단한 단계에 따라 시작하세요",
                installation: {
                    title: "설치",
                    step1: "워드프레스 플러그인 저장소에서 다운로드",
                    step2: "플러그인 디렉토리에 업로드",
                    step3: "워드프레스 관리자 패널에서 활성화"
                },
                configuration: {
                    title: "설정",
                    step1: "워드프레스 관리자의 설정 > 자동 링크로 이동",
                    step2: "대소문자 구분과 최대 링크 수와 같은 전역 설정 구성",
                    step3: "키워드와 해당 URL 추가"
                },
                usage: {
                    title: "사용법",
                    step1: "게시물 태그가 자동으로 링크로 변환됩니다",
                    step2: "관리 패널에서 사용자 지정 키워드 보기",
                    step3: "필요에 따라 설정 조정"
                }
            },
            testimonials: {
                title: "사용자 후기",
                subtitle: "전 세계 사용자의 실제 피드백",
                review1: "제가 사용해 본 최고의 자동 링크 플러그인입니다. 시간이 많이 절약되고 SEO가 크게 향상되었습니다!",
                client1: "사라 존슨",
                position1: "기술 블로거",
                review2: "직관적인 인터페이스와 강력한 기능성으로 제 요구를 완벽히 충족시킵니다. 한 달 사용 후, 사이트 트래픽이 20% 증가했습니다.",
                client2: "데이비드 첸",
                position2: "SEO 전문가",
                review3: "고객 지원이 신속하고 전문적입니다. 제가 겪은 모든 문제가 즉시 해결되었습니다.",
                client3: "마리아 가르시아",
                position3: "콘텐츠 관리자"
            },
            faq: {
                title: "자주 묻는 질문",
                subtitle: "일반적인 질문에 대한 답변",
                q1: "일부 키워드가 자동으로 링크되지 않는 이유는 무엇인가요?",
                a1: "최대 링크 수를 초과했는지, 대소문자 설정이 충족되는지 확인하세요. 키워드가 HTML 태그 내부나 기존 링크 내에 있는 경우 대체되지 않습니다.",
                q2: "특정 게시물에서 링크 생성을 비활성화하려면 어떻게 해야 하나요?",
                a2: "관리 패널의 자동 링크 설정에서 제외할 게시물을 추가하기만 하면 됩니다."
            },
            changelog: {
                title: "변경 내역",
                subtitle: "더 나은 경험을 위한 지속적인 개선",
                v2: {
                    feature1: "키워드 관리를 위한 생성 시간 표시 기능 추가",
                    feature2: "작업 경험 향상을 위한 UI/UX 최적화",
                    feature3: "국제 사용자 요구를 충족하기 위한 다국어 지원(8개 언어) 추가"
                },
                v1: {
                    feature1: "기본 기능을 갖춘 최초 출시",
                    feature2: "키워드 매칭을 통한 기본 자동 링크 기능",
                    feature3: "키워드 및 링크 관리를 위한 관리자 인터페이스"
                }
            },
            support: {
                title: "지원",
                subtitle: "도움이 필요하신가요",
                documentation: {
                    title: "문서",
                    description: "플러그인을 최대한 활용할 수 있는 상세 가이드 및 튜토리얼",
                    button: "문서 보기"
                },
                forum: {
                    title: "Github",
                    description: "여기서 편하게 질문하고 필요한 사항을 알려주세요",
                    button: "Github 방문하기"
                },
                contact: {
                    title: "연락처",
                    description: "질문에 답변해 드릴 전문 지원 팀이 준비되어 있습니다",
                    button: "이메일 보내기"
                }
            },
            footer: {
                about: {
                    title: "자동 링크 생성기 소개",
                    description: "웹사이트 SEO 성능과 사용자 경험 향상에 전념하는 강력한 워드프레스 자동 내부 링크 플러그인"
                },
                links: {
                    title: "빠른 링크",
                    features: "기능",
                    docs: "문서",
                    support: "지원"
                },
                social: {
                    title: "팔로우하기"
                },
                copyright: "© 2024 자동 링크 생성기. 모든 권리 보유.",
                license: "GPLv2 라이센스 하에 출시되었습니다. 전체 텍스트는 LICENSE 파일에 있습니다."
            }
        }
    },
    de: {
        translation: {
            hero: {
                title: "Auto Link Generator",
                description: "Intelligente automatische interne Linkerzeugung zur Verbesserung von SEO und Benutzererfahrung",
                button: {
                    features: "Funktionen anzeigen"
                }
            },
            features: {
                title: "Hauptfunktionen",
                subtitle: "Leistungsstarke Tools zur Verbesserung der SEO und Benutzererfahrung Ihrer Website",
                automatic: {
                    title: "Automatische Linkerzeugung",
                    description: "Automatische Umwandlung von Schlüsselwörtern in Links basierend auf vordefinierten Regeln zur Verbesserung der Inhaltsverbindung"
                },
                tags: {
                    title: "Tag-Integration",
                    description: "Automatische Linkerzeugung aus Artikel-Tags zur Verbesserung der Inhaltsbeziehungen"
                },
                management: {
                    title: "Erweiterte Verwaltung",
                    description: "Einfache und elegante Admin-Oberfläche zur bequemen Verwaltung aller Beitragslinks"
                }
            },
            requirements: {
                title: "Systemanforderungen",
                subtitle: "Stellen Sie sicher, dass Ihr System diese Anforderungen für optimale Leistung erfüllt",
                wordpress: "WordPress 5.0 oder höher",
                php: "PHP 7.0 oder höher",
                mysql: "MySQL 5.6 oder höher",
                browsers: "Moderne Browser"
            },
            guide: {
                title: "Nutzerhandbuch",
                subtitle: "Folgen Sie diesen einfachen Schritten, um zu beginnen",
                installation: {
                    title: "Installation",
                    step1: "Herunterladen aus dem WordPress-Plugin-Repository",
                    step2: "Hochladen in Ihr Plugin-Verzeichnis",
                    step3: "Aktivieren über WordPress-Admin"
                },
                configuration: {
                    title: "Konfiguration",
                    step1: "Gehen Sie zu Einstellungen > Auto Link im WordPress-Admin",
                    step2: "Konfigurieren Sie globale Einstellungen wie Groß-/Kleinschreibung und maximale Links",
                    step3: "Fügen Sie Schlüsselwörter und entsprechende URLs hinzu"
                },
                usage: {
                    title: "Verwendung",
                    step1: "Beitrags-Tags werden automatisch in Links umgewandelt",
                    step2: "Benutzerdefinierte Schlüsselwörter im Admin-Panel einsehen",
                    step3: "Einstellungen nach Bedarf anpassen"
                }
            },
            testimonials: {
                title: "Kundenstimmen",
                subtitle: "Echtes Feedback von Nutzern aus der ganzen Welt",
                review1: "Das ist das beste automatische Linking-Plugin, das ich je verwendet habe. Es spart so viel Zeit! Signifikante SEO-Verbesserungen.",
                client1: "Sarah Johnson",
                position1: "Tech-Bloggerin",
                review2: "Intuitive Benutzeroberfläche, leistungsstarke Funktionalität, erfüllt meine Bedürfnisse vollständig. Nach einem Monat Nutzung ist mein Website-Traffic um 20% gestiegen.",
                client2: "David Chen",
                position2: "SEO-Spezialist",
                review3: "Der Kundensupport ist reaktionsschnell und professionell. Jedes Problem, auf das ich gestoßen bin, wurde umgehend gelöst.",
                client3: "Maria Garcia",
                position3: "Content-Managerin"
            },
            faq: {
                title: "FAQ",
                subtitle: "Antworten auf häufig gestellte Fragen",
                q1: "Warum werden einige Schlüsselwörter nicht automatisch verlinkt?",
                a1: "Bitte prüfen Sie, ob die maximale Anzahl der Links überschritten wurde und ob die Einstellungen für Groß-/Kleinschreibung erfüllt sind. In einigen Fällen werden Schlüsselwörter innerhalb von HTML-Tags oder in vorhandenen Links nicht ersetzt.",
                q2: "Wie deaktiviere ich die Verlinkung in bestimmten Artikeln?",
                a2: "Fügen Sie einfach die ausgeschlossenen Beiträge in den Auto Link-Einstellungen im Admin-Panel hinzu."
            },
            changelog: {
                title: "Änderungsprotokoll",
                subtitle: "Kontinuierliche Verbesserungen für ein besseres Erlebnis",
                v2: {
                    feature1: "Anzeige der Erstellungszeit für besseres Schlüsselwort-Management hinzugefügt",
                    feature2: "Optimierte UI/UX für eine bessere Bedienungserfahrung",
                    feature3: "Mehrsprachige Unterstützung (8 Sprachen) hinzugefügt, um internationalen Nutzeranforderungen gerecht zu werden"
                },
                v1: {
                    feature1: "Erstveröffentlichung mit grundlegenden Funktionen",
                    feature2: "Grundlegende automatische Verlinkung mit Schlüsselwortabgleich",
                    feature3: "Admin-Oberfläche zur Verwaltung von Schlüsselwörtern und Links"
                }
            },
            support: {
                title: "Support",
                subtitle: "Wir sind für Sie da",
                documentation: {
                    title: "Dokumentation",
                    description: "Detaillierte Anleitungen und Tutorials, um das Beste aus dem Plugin herauszuholen",
                    button: "Dokumentation ansehen"
                },
                forum: {
                    title: "Github",
                    description: "Hier können Sie mir gerne Fragen stellen und Ihre Wünsche mitteilen",
                    button: "Github besuchen"
                },
                contact: {
                    title: "Kontakt",
                    description: "Professionelles Support-Team, bereit, Ihre Fragen zu beantworten",
                    button: "E-Mail senden"
                }
            },
            footer: {
                about: {
                    title: "Über Auto Link Generator",
                    description: "Ein leistungsstarkes WordPress-Plugin für automatische interne Verlinkung, das sich der Verbesserung der SEO-Leistung und Benutzererfahrung widmet"
                },
                links: {
                    title: "Schnelllinks",
                    features: "Funktionen",
                    docs: "Dokumentation",
                    support: "Support"
                },
                social: {
                    title: "Folgen Sie uns"
                },
                copyright: "© 2024 Auto Link Generator. Alle Rechte vorbehalten.",
                license: "Veröffentlicht unter GPLv2-Lizenz. Vollständiger Text in der LICENSE-Datei."
            }
        }
    },
    fr: {
        translation: {
            hero: {
                title: "Générateur de Liens Automatique",
                description: "Génération intelligente de liens internes automatiques, améliorant le SEO et l'expérience utilisateur",
                button: {
                    features: "Voir les Fonctionnalités"
                }
            },
            features: {
                title: "Fonctionnalités Clés",
                subtitle: "Des outils puissants pour améliorer le SEO et l'expérience utilisateur de votre site",
                automatic: {
                    title: "Génération Automatique de Liens",
                    description: "Conversion automatique des mots-clés en liens basée sur des règles prédéfinies, améliorant la connectivité du contenu"
                },
                tags: {
                    title: "Intégration des Tags",
                    description: "Génération automatique de liens à partir des tags d'articles, renforçant les relations entre contenus"
                },
                management: {
                    title: "Gestion Avancée",
                    description: "Interface d'administration simple et élégante pour gérer facilement tous les liens d'articles"
                }
            },
            requirements: {
                title: "Prérequis Système",
                subtitle: "Assurez-vous que votre système répond à ces exigences pour des performances optimales",
                wordpress: "WordPress 5.0+",
                php: "PHP 7.0+",
                mysql: "MySQL 5.6+",
                browsers: "Navigateurs Modernes"
            },
            guide: {
                title: "Guide d'Utilisation",
                subtitle: "Suivez ces étapes simples pour commencer",
                installation: {
                    title: "Installation",
                    step1: "Téléchargez depuis le répertoire de plugins WordPress",
                    step2: "Uploadez dans votre répertoire de plugins",
                    step3: "Activez via l'administration WordPress"
                },
                configuration: {
                    title: "Configuration",
                    step1: "Allez dans Réglages > Auto Link dans l'admin WordPress",
                    step2: "Configurez les paramètres globaux comme la sensibilité à la casse et le nombre maximal de liens",
                    step3: "Ajoutez des mots-clés et les URLs correspondantes"
                },
                usage: {
                    title: "Utilisation",
                    step1: "Les tags des articles seront automatiquement convertis en liens",
                    step2: "Consultez les mots-clés personnalisés dans le panneau d'administration",
                    step3: "Ajustez les paramètres selon vos besoins"
                }
            },
            testimonials: {
                title: "Témoignages",
                subtitle: "Retours réels d'utilisateurs du monde entier",
                review1: "C'est le meilleur plugin de liaison automatique que j'ai jamais utilisé. Il fait gagner tellement de temps ! Améliorations SEO significatives.",
                client1: "Sarah Johnson",
                position1: "Blogueuse Tech",
                review2: "Interface intuitive, fonctionnalité puissante, répond complètement à mes besoins. Après un mois d'utilisation, le trafic de mon site a augmenté de 20%.",
                client2: "David Chen",
                position2: "Spécialiste SEO",
                review3: "Le support client est réactif et professionnel. Chaque problème que j'ai rencontré a été rapidement résolu.",
                client3: "Maria Garcia",
                position3: "Gestionnaire de Contenu"
            },
            faq: {
                title: "FAQ",
                subtitle: "Réponses aux questions fréquentes",
                q1: "Pourquoi certains mots-clés ne sont pas automatiquement liés ?",
                a1: "Veuillez vérifier si le nombre maximal de liens a été dépassé et si les paramètres de sensibilité à la casse sont respectés. Dans certains cas, les mots-clés à l'intérieur des balises HTML ou dans des liens existants ne seront pas remplacés.",
                q2: "Comment désactiver la liaison dans des articles spécifiques ?",
                a2: "Ajoutez simplement les articles exclus dans les paramètres d'Auto Link du panneau d'administration."
            },
            changelog: {
                title: "Journal des Modifications",
                subtitle: "Améliorations continues pour une meilleure expérience",
                v2: {
                    feature1: "Ajout de l'affichage du temps de création pour une meilleure gestion des mots-clés",
                    feature2: "Optimisation de l'UI/UX pour une meilleure expérience d'utilisation",
                    feature3: "Ajout du support multilingue (8 langues) pour répondre aux besoins internationaux"
                },
                v1: {
                    feature1: "Première version avec fonctionnalités de base",
                    feature2: "Fonction de liaison automatique basique avec correspondance des mots-clés",
                    feature3: "Interface d'administration pour la gestion des mots-clés et des liens"
                }
            },
            support: {
                title: "Support",
                subtitle: "Nous sommes là pour vous aider",
                documentation: {
                    title: "Documentation",
                    description: "Guides détaillés et tutoriels pour tirer le meilleur parti du plugin",
                    button: "Voir la Documentation"
                },
                forum: {
                    title: "Github",
                    description: "N'hésitez pas à poser vos questions et à partager vos besoins ici",
                    button: "Visiter Github"
                },
                contact: {
                    title: "Contact",
                    description: "Équipe de support professionnelle prête à répondre à vos questions",
                    button: "Envoyer un Email"
                }
            },
            footer: {
                about: {
                    title: "À Propos du Générateur de Liens Automatique",
                    description: "Un plugin WordPress puissant pour la liaison interne automatique, dédié à l'amélioration des performances SEO et de l'expérience utilisateur"
                },
                links: {
                    title: "Liens Rapides",
                    features: "Fonctionnalités",
                    docs: "Documentation",
                    support: "Support"
                },
                social: {
                    title: "Suivez-nous"
                },
                copyright: "© 2024 Générateur de Liens Automatique. Tous droits réservés.",
                license: "Publié sous licence GPLv2. Texte complet dans le fichier LICENSE."
            }
        }
    },
    es: {
        translation: {
            hero: {
                title: "Generador de Enlaces Automático",
                description: "Generación inteligente de enlaces internos automáticos, mejorando SEO y experiencia de usuario",
                button: {
                    features: "Ver Características"
                }
            },
            features: {
                title: "Características Principales",
                subtitle: "Herramientas poderosas para mejorar el SEO y la experiencia de usuario de su sitio web",
                automatic: {
                    title: "Generación Automática de Enlaces",
                    description: "Conversión automática de palabras clave en enlaces basada en reglas predefinidas"
                },
                tags: {
                    title: "Integración de Etiquetas",
                    description: "Generación automática de enlaces desde etiquetas de artículos"
                },
                management: {
                    title: "Gestión Avanzada",
                    description: "Interfaz de administración simple y elegante para gestionar fácilmente todos los enlaces de artículos"
                }
            },
            requirements: {
                title: "Requisitos del Sistema",
                subtitle: "Asegúrese de que su sistema cumple con estos requisitos",
                wordpress: "WordPress 5.0 o superior",
                php: "PHP 7.0 o superior",
                mysql: "MySQL 5.6 o superior",
                browsers: "Navegadores modernos"
            },
            guide: {
                title: "Guía de Uso",
                subtitle: "Siga estos sencillos pasos para comenzar",
                installation: {
                    title: "Instalación",
                    step1: "Descargue desde el repositorio de plugins de WordPress",
                    step2: "Suba a su directorio de plugins",
                    step3: "Active a través del admin de WordPress"
                },
                configuration: {
                    title: "Configuración",
                    step1: "Vaya a Ajustes > Auto Link en el admin de WordPress",
                    step2: "Configure ajustes globales como sensibilidad a mayúsculas y enlaces máximos",
                    step3: "Agregue palabras clave y URLs correspondientes"
                },
                usage: {
                    title: "Uso",
                    step1: "Las etiquetas de artículos se convertirán automáticamente en enlaces",
                    step2: "Vea palabras clave personalizadas en el panel de administración",
                    step3: "Ajuste la configuración según sea necesario"
                }
            },
            testimonials: {
                title: "Testimonios",
                subtitle: "Comentarios reales de usuarios de todo el mundo",
                review1: "El mejor plugin de enlazado automático que he usado. ¡Ahorra mucho tiempo! Mejoras significativas en SEO.",
                client1: "Sarah Johnson",
                position1: "Bloguera de Tecnología",
                review2: "Interfaz intuitiva, funcionalidad potente, cumple completamente mis necesidades. Después de un mes de uso, mi tráfico aumentó un 20%.",
                client2: "David Chen",
                position2: "Especialista en SEO",
                review3: "El soporte al cliente es receptivo y profesional. Cada problema que encontré se resolvió rápidamente.",
                client3: "Maria Garcia",
                position3: "Gestora de Contenido"
            },
            faq: {
                title: "Preguntas Frecuentes",
                subtitle: "Respuestas a preguntas comunes",
                q1: "¿Por qué algunas palabras clave no se enlazan automáticamente?",
                a1: "Verifique si se ha excedido el número máximo de enlaces y si se cumplen las configuraciones de sensibilidad a mayúsculas. En algunos casos, las palabras clave dentro de etiquetas HTML o enlaces existentes no se reemplazarán.",
                q2: "¿Cómo deshabilitar el enlazado en artículos específicos?",
                a2: "Simplemente agregue los artículos excluidos en la configuración de Auto Link en el panel de administración."
            },
            changelog: {
                title: "Registro de Cambios",
                subtitle: "Mejoras continuas para una mejor experiencia",
                v2: {
                    feature1: "Agregada visualización de tiempo de creación para mejor gestión de palabras clave",
                    feature2: "Optimizada UI/UX para mejor experiencia operativa",
                    feature3: "Agregado soporte multiidioma (8 idiomas) para satisfacer necesidades internacionales"
                },
                v1: {
                    feature1: "Lanzamiento inicial con funcionalidad básica",
                    feature2: "Función básica de enlazado automático con coincidencia de palabras clave",
                    feature3: "Interfaz de administración para gestión de palabras clave y enlaces"
                }
            },
            support: {
                title: "Soporte",
                subtitle: "Estamos aquí para ayudar",
                documentation: {
                    title: "Documentación",
                    description: "Guías detalladas y tutoriales para aprovechar al máximo el plugin",
                    button: "Ver Documentación"
                },
                forum: {
                    title: "Github",
                    description: "No dudes en hacerme preguntas y contarme tus necesidades aquí",
                    button: "Visitar Github"
                },
                contact: {
                    title: "Contacto",
                    description: "Equipo de soporte profesional listo para responder sus preguntas",
                    button: "Enviar Email"
                }
            },
            footer: {
                about: {
                    title: "Acerca del Generador de Enlaces Automático",
                    description: "Un potente plugin de WordPress para enlazado interno automático, dedicado a mejorar el rendimiento SEO y la experiencia de usuario"
                },
                links: {
                    title: "Enlaces Rápidos",
                    features: "Características",
                    docs: "Documentación",
                    support: "Soporte"
                },
                social: {
                    title: "Síguenos"
                },
                copyright: "© 2024 Generador de Enlaces Automático. Todos los derechos reservados.",
                license: "Publicado bajo licencia GPLv2. Texto completo en archivo LICENSE."
            }
        }
    }
};

// Initialize i18next
i18next.init({
    resources: resources,
    lng: 'en', // Default to English
    fallbackLng: 'en'
}).then(function (t) {
    updateContent();
});

// Update page content
function updateContent() {
    document.querySelectorAll('[data-i18n]').forEach(element => {
        const key = element.getAttribute('data-i18n');
        element.innerHTML = i18next.t(key);
    });
}

// Language switching handler
function changeLanguage(lng) {
    i18next.changeLanguage(lng).then(updateContent);
}

// Language switching handler (for direct use with event listener)
document.getElementById('languageSelect').addEventListener('change', function (e) {
    changeLanguage(e.target.value);
});
