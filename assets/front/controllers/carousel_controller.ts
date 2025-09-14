import { Controller } from "@hotwired/stimulus";

export default class extends Controller {
  static targets = ['track', 'item'];
  declare readonly trackTarget: HTMLElement
  declare readonly itemTargets: HTMLElement[]

  static values = {
    interval: { type: Number, default: 3000 }, // ms
    pauseOnHover: { type: Boolean, default: true },
    autoStart: { type: Boolean, default: true },
  }
  declare readonly intervalValue: number
  declare readonly pauseOnHoverValue: boolean
  declare readonly autoStartValue: boolean

  private currentIndex: number = 0
  private intervalId: number | null = null
  private mutationObserver: MutationObserver | null = null
  private stopBound!: () => void
  private startBound!: () => void
  private resizeHandler!: () => void

  connect() {
    this.currentIndex = 0
    this.trackTarget.style.transition = this.trackTarget.style.transition || 'transform 0.8s ease-in-out'
    this.trackTarget.style.willChange = 'transform'

    if (this.itemTargets.length <= 1) return

    if (this.autoStartValue) this.start()

    if (this.pauseOnHoverValue) {
      this.stopBound = () => this.stop()
      this.startBound = () => this.start()
      this.element.addEventListener('mouseenter', this.stopBound)
      this.element.addEventListener('mouseleave', this.startBound)
    }

    this.mutationObserver = new MutationObserver(() => {
      if (this.itemTargets.length <= 1) {
        this.stop()
        this.goTo(0)
      } else if (!this.intervalId && this.autoStartValue) {
        this.start()
      }
      this.updateItemWidths()
    })
    this.mutationObserver.observe(this.trackTarget, { childList: true })

    this.resizeHandler = () => this.updateItemWidths()
    window.addEventListener('resize', this.resizeHandler)

    this.updateItemWidths()
  }

  disconnect() {
    this.stop()

    if (this.pauseOnHoverValue) {
      this.element.removeEventListener('mouseenter', this.stopBound)
      this.element.removeEventListener('mouseleave', this.startBound)
    }

    if (this.mutationObserver) {
      this.mutationObserver.disconnect()
      this.mutationObserver = null
    }

    window.removeEventListener('resize', this.resizeHandler)
  }

  start() {
    if (this.itemTargets.length <= 1) return
    this.stop()
    this.intervalId = window.setInterval(() => this.next(), this.intervalValue)
  }

  stop() {
    if (this.intervalId) {
      clearInterval(this.intervalId)
      this.intervalId = null
    }
  }

  next() {
    if (this.itemTargets.length <= 1) return
    this.currentIndex = (this.currentIndex + 1) % this.itemTargets.length
    this.goTo(this.currentIndex)
  }

  prev() {
    if (this.itemTargets.length <= 1) return
    this.currentIndex = (this.currentIndex - 1 + this.itemTargets.length) % this.itemTargets.length
    this.goTo(this.currentIndex)
  }

  goTo(index: number) {
    if (this.itemTargets.length === 0) return
    const clamped = ((index % this.itemTargets.length) + this.itemTargets.length) % this.itemTargets.length
    this.currentIndex = clamped
    this.trackTarget.style.transform = `translateX(-${clamped * 100}%)`
  }

  private updateItemWidths() {
    this.itemTargets.forEach((item) => {
      item.style.flex = '0 0 100%'
      item.style.maxWidth = '100%'
    })
    this.trackTarget.style.transform = `translateX(-${this.currentIndex * 100}%)`
  }
}
